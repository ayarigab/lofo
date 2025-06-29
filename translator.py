#!/usr/bin/env python3
import json
import time
import random
import os
import re
import csv
from pathlib import Path
from tqdm import tqdm
from deep_translator import GoogleTranslator, MyMemoryTranslator, MicrosoftTranslator

class LaravelTranslator:
    def __init__(self, config):
        self.cache_file = Path('.translation_cache.json')
        self.cache = self._load_cache()
        self.config = config
        self.language_map = {
            'ar': 'ar', 'en': 'en', 'es': 'es', 'fr': 'fr',
            'de': 'de', 'fa': 'fa', 'ha': 'ha', 'hi': 'hi',
            'it': 'it', 'pt': 'pt', 'pt-BR': 'pt', 'ru': 'ru',
            'vi': 'vi', 'zh': 'zh-CN', 'zh-CN': 'zh-CN',
            'zh-TW': 'zh-TW'
        }
        self.mymemory_language_map = {
            'ar': 'ar-SA', 'en': 'en-GB', 'es': 'es-ES', 'fr': 'fr-FR',
            'de': 'de-DE', 'fa': 'fa-IR', 'ha': 'ha-NE', 'hi': 'hi-IN',
            'it': 'it-IT', 'pt': 'pt-PT', 'pt-BR': 'pt-BR', 'ru': 'ru-RU',
            'vi': 'vi-VN', 'zh-CN': 'zh-CN', 'zh-TW': 'zh-TW'
        }
        self.request_count = 0
        self.last_request_time = 0

    def _load_cache(self):
        try:
            return json.loads(self.cache_file.read_text(encoding='utf-8')) if self.cache_file.exists() else {}
        except:
            return {}

    def _save_cache(self):
        self.cache_file.write_text(json.dumps(self.cache, indent=2, ensure_ascii=False), encoding='utf-8')

    def _rate_limit(self):
        """Implement careful rate limiting"""
        now = time.time()
        elapsed = now - self.last_request_time

        if self.request_count > 5 and elapsed < 10:
            time.sleep(random.uniform(1.5, 3.0))
        elif elapsed < 0.5:
            time.sleep(0.5 - elapsed)

        self.last_request_time = time.time()
        self.request_count += 1

    def _preserve_placeholders(self, text: str, translated: str) -> str:
        """Preserve Laravel-style placeholders"""
        placeholders = re.findall(r'(:\w+)', text)
        for ph in placeholders:
            ph_text = ph[1:].lower()
            translated_lower = translated.lower()
            pos = translated_lower.find(ph_text)
            if pos != -1:
                translated = translated[:pos] + ph + translated[pos+len(ph_text):]
            elif ph not in translated:
                translated += f" {ph}"
        return translated

    def translate_text(self, text: str, target_lang: str, source_lang: str = 'en') -> str:
        if not isinstance(text, str):
            return text

        api = self.config.get('translation_api', 'google')
        cache_key = f"{source_lang}_{target_lang}_{api}_{text}"
        if cache_key in self.cache:
            return self.cache[cache_key]

        try:
            self._rate_limit()
            translated = ""

            # Handle language code mapping based on API
            if api == 'mymemory':
                source_lang = self.mymemory_language_map.get(source_lang, source_lang)
                target_lang = self.mymemory_language_map.get(target_lang, target_lang)
            else:
                source_lang = self.language_map.get(source_lang, source_lang)
                target_lang = self.language_map.get(target_lang, target_lang)

            if api == 'google':
                translated = GoogleTranslator(
                    source=source_lang,
                    target=target_lang
                ).translate(text)
            elif api == 'mymemory':
                # Enhanced MyMemory translator with better error handling
                email = self.config.get('api_key_username') or 'no-reply@example.com'

                # First try with full language code (e.g., en-GB)
                try:
                    translator = MyMemoryTranslator(
                        source=source_lang,
                        target=target_lang,
                        email=email
                    )
                    result = translator.translate(text)
                    translated = result['translatedText'] if isinstance(result, dict) else result
                except Exception as e:
                    # Fallback to simple language code (e.g., en)
                    simple_source = source_lang.split('-')[0]
                    simple_target = target_lang.split('-')[0]
                    if simple_source != source_lang or simple_target != target_lang:
                        translator = MyMemoryTranslator(
                            source=simple_source,
                            target=simple_target,
                            email=email
                        )
                        result = translator.translate(text)
                        translated = result['translatedText'] if isinstance(result, dict) else result
                    else:
                        raise e

            elif api == 'microsoft':
                if not self.config.get('api_key_username') and not os.getenv('AZURE_TRANSLATOR_KEY'):
                    raise ValueError("Microsoft Translator requires an API key")

                translator = MicrosoftTranslator(
                    source=source_lang,
                    target=target_lang,
                    api_key=self.config.get('api_key_username') or os.getenv('AZURE_TRANSLATOR_KEY'),
                    region=self.config.get('api_region') or os.getenv('AZURE_TRANSLATOR_REGION')
                )
                translated = translator.translate(text)

            translated = self._preserve_placeholders(text, translated)
            self.cache[cache_key] = translated
            self._save_cache()
            return translated
        except Exception as e:
            print(f"⚠️ Failed to translate '{text}' ({source_lang}→{target_lang}): {str(e)}")
            return text

    def process_file(self):
        try:
            translations = self.config['translations']
            source_lang = self.config['source_language']
            target_langs = self.config['target_languages']
            file_format = self.config.get('file_format', 'php')
            filename = self.config.get('filename', 'translations')
            export_csv = self.config.get('export_csv', False)
            csv_single_file = self.config.get('csv_single_file', False)

            # Process translations
            all_translations = {}
            for lang in target_langs:
                print(f"\n🌐 Translating to {lang.upper()}")
                translated = self._translate_nested(translations, lang, source_lang) if any(isinstance(v, dict) for v in translations.values()) else {
                    key: self.translate_text(text, lang, source_lang)
                    for key, text in tqdm(translations.items(), desc="Translating")
                }
                all_translations[lang] = translated
                self._save_translations(lang, translated, filename, file_format)

            # Handle CSV export
            if export_csv:
                if csv_single_file:
                    self._export_to_single_csv(all_translations, filename)
                else:
                    self._export_to_multiple_csv(all_translations, filename)

        except Exception as e:
            print(f"❌ Fatal error: {str(e)}")
            raise

    def _translate_nested(self, data: dict, target_lang: str, source_lang: str) -> dict:
        """Handle nested dictionary structures"""
        result = {}
        for key, value in tqdm(data.items(), desc="Processing nested"):
            result[key] = self._translate_nested(value, target_lang, source_lang) if isinstance(value, dict) else self.translate_text(value, target_lang, source_lang)
        return result

    def _save_translations(self, lang: str, translations: dict, filename: str, format: str):
        """Save translations to PHP/JSON files"""
        output_dir = Path(f"resources/lang/{lang}")
        output_dir.mkdir(parents=True, exist_ok=True)
        output_file = output_dir / f"{filename}.{format}"

        content = self._generate_php(translations) if format == 'php' else json.dumps(translations, indent=2, ensure_ascii=False)
        output_file.write_text(content, encoding='utf-8')
        print(f"✅ Saved {output_file}")

    def _export_to_single_csv(self, all_translations: dict, filename: str):
        """Export all translations to a single CSV file"""
        csv_file = Path(f"translations_export/{filename}.csv")
        csv_file.parent.mkdir(parents=True, exist_ok=True)

        # Get all unique keys
        all_keys = set()
        for translations in all_translations.values():
            self._collect_keys(translations, all_keys)

        # Write CSV
        with open(csv_file, 'w', newline='', encoding='utf-8') as f:
            writer = csv.writer(f)
            # Write header
            writer.writerow(['Key'] + list(all_translations.keys()))

            # Write each key's translations
            for key in sorted(all_keys):
                row = [key]
                for lang in all_translations.keys():
                    value = self._get_nested_value(all_translations[lang], key)
                    row.append(value if value is not None else '')
                writer.writerow(row)

        print(f"📊 Exported all translations to {csv_file}")

    def _export_to_multiple_csv(self, all_translations: dict, filename: str):
        """Export translations to separate CSV files per language"""
        csv_dir = Path(f"translations_export/{filename}")
        csv_dir.mkdir(parents=True, exist_ok=True)

        for lang, translations in all_translations.items():
            csv_file = csv_dir / f"{lang}.csv"
            self._write_language_csv(translations, csv_file)
            print(f"📊 Exported {lang} translations to {csv_file}")

    def _write_language_csv(self, translations: dict, csv_file: Path):
        """Write a single language's translations to CSV"""
        with open(csv_file, 'w', newline='', encoding='utf-8') as f:
            writer = csv.writer(f)
            writer.writerow(['Key', 'Translation'])

            for key, value in self._flatten_dict(translations).items():
                writer.writerow([key, value])

    def _flatten_dict(self, data: dict, parent_key: str = '') -> dict:
        """Flatten nested dictionary structure"""
        items = {}
        for key, value in data.items():
            new_key = f"{parent_key}.{key}" if parent_key else key
            if isinstance(value, dict):
                items.update(self._flatten_dict(value, new_key))
            else:
                items[new_key] = value
        return items

    def _collect_keys(self, data: dict, keys: set, parent_key: str = ''):
        """Collect all keys from nested structure"""
        for key, value in data.items():
            new_key = f"{parent_key}.{key}" if parent_key else key
            if isinstance(value, dict):
                self._collect_keys(value, keys, new_key)
            else:
                keys.add(new_key)

    def _get_nested_value(self, data: dict, dotted_key: str):
        """Get value from nested dict using dotted notation"""
        keys = dotted_key.split('.')
        value = data
        for key in keys:
            if isinstance(value, dict) and key in value:
                value = value[key]
            else:
                return None
        return value

    def _generate_php(self, data: dict) -> str:
        """Generate PHP array with proper nesting"""
        php = ["<?php", "", "return ["]

        def build_level(items, indent=1):
            for key, value in items.items():
                spacing = "    " * indent
                if isinstance(value, dict):
                    php.append(f"{spacing}'{key}' => [")
                    build_level(value, indent + 1)
                    php.append(f"{spacing}],")
                else:
                    escaped = str(value).replace("'", "\\'")
                    php.append(f"{spacing}'{key}' => '{escaped}',")

        build_level(data)
        php.append("];")
        return "\n".join(php)

    @staticmethod
    def import_csv(csv_path: str, output_format: str = 'php', filename: str = 'translations'):
        """Import CSV file back to PHP/JSON format"""
        csv_path = Path(csv_path)
        if not csv_path.exists():
            print(f"❌ CSV file not found: {csv_path}")
            return

        # Determine if single file or directory of language files
        if csv_path.is_dir():
            # Process directory of language CSVs
            for lang_file in csv_path.glob('*.csv'):
                lang = lang_file.stem
                translations = LaravelTranslator._read_language_csv(lang_file)
                LaravelTranslator._save_imported_translations(lang, translations, output_format, filename)
        else:
            # Process single multi-language CSV
            translations = LaravelTranslator._read_multi_lang_csv(csv_path)
            for lang, lang_translations in translations.items():
                LaravelTranslator._save_imported_translations(lang, lang_translations, output_format, filename)

    @staticmethod
    def _read_language_csv(csv_file: Path) -> dict:
        """Read single language CSV into nested dict"""
        translations = {}
        with open(csv_file, 'r', encoding='utf-8') as f:
            reader = csv.reader(f)
            next(reader)  # Skip header
            for row in reader:
                if len(row) >= 2:
                    key, value = row[0], row[1]
                    LaravelTranslator._set_nested_value(translations, key, value)
        return translations

    @staticmethod
    def _read_multi_lang_csv(csv_file: Path) -> dict:
        """Read multi-language CSV into dict of lang:translations"""
        translations = {}
        with open(csv_file, 'r', encoding='utf-8') as f:
            reader = csv.reader(f)
            headers = next(reader)
            languages = headers[1:]  # First column is key

            for lang in languages:
                translations[lang] = {}

            for row in reader:
                if len(row) > 1:
                    key = row[0]
                    for i, lang in enumerate(languages, start=1):
                        if i < len(row):
                            LaravelTranslator._set_nested_value(translations[lang], key, row[i])

        return translations

    @staticmethod
    def _set_nested_value(data: dict, dotted_key: str, value: str):
        """Set value in nested dict using dotted notation"""
        keys = dotted_key.split('.')
        current = data
        for key in keys[:-1]:
            if key not in current:
                current[key] = {}
            current = current[key]
        current[keys[-1]] = value

    @staticmethod
    def _save_imported_translations(lang: str, translations: dict, output_format: str, filename: str):
        """Save imported translations to file"""
        output_dir = Path(f"resources/lang/{lang}")
        output_dir.mkdir(parents=True, exist_ok=True)
        output_file = output_dir / f"{filename}.{output_format}"

        if output_format == 'php':
            content = LaravelTranslator._generate_php_static(translations)
        else:
            content = json.dumps(translations, indent=2, ensure_ascii=False)

        output_file.write_text(content, encoding='utf-8')
        print(f"✅ Imported and saved {lang} translations to {output_file}")

    @staticmethod
    def _generate_php_static(data: dict) -> str:
        """Static version of PHP generator for import"""
        php = ["<?php", "", "return ["]

        def build_level(items, indent=1):
            for key, value in items.items():
                spacing = "    " * indent
                if isinstance(value, dict):
                    php.append(f"{spacing}'{key}' => [")
                    build_level(value, indent + 1)
                    php.append(f"{spacing}],")
                else:
                    escaped = str(value).replace("'", "\\'")
                    php.append(f"{spacing}'{key}' => '{escaped}',")

        build_level(data)
        php.append("];")
        return "\n".join(php)

if __name__ == '__main__':
    import sys
    import argparse

    parser = argparse.ArgumentParser(description='Laravel Translation Tool')
    subparsers = parser.add_subparsers(dest='command', required=True)

    # Translate command
    translate_parser = subparsers.add_parser('translate', help='Translate using config file')
    translate_parser.add_argument('config_file', help='Path to config.json')

    # Import command
    import_parser = subparsers.add_parser('import', help='Import CSV translations')
    import_parser.add_argument('csv_path', help='Path to CSV file or directory')
    import_parser.add_argument('--format', default='php', choices=['php', 'json'], help='Output file format')
    import_parser.add_argument('--filename', default='translations', help='Base filename for output')

    args = parser.parse_args()

    try:
        if args.command == 'translate':
            with open(args.config_file, 'r', encoding='utf-8') as f:
                config = json.load(f)
            translator = LaravelTranslator(config)
            translator.process_file()
        elif args.command == 'import':
            LaravelTranslator.import_csv(args.csv_path, args.format, args.filename)
    except Exception as e:
        print(f"🔥 Critical error: {str(e)}")
        sys.exit(1)
