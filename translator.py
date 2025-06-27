#!/usr/bin/env python3
import json
import time
from pathlib import Path
from tqdm import tqdm
from deep_translator import GoogleTranslator

class LaravelTranslator:
    def __init__(self):
        self.cache_file = Path('.translation_cache.json')
        self.cache = self._load_cache()
        self.language_map = {
            'ar': 'ar', 'en': 'en', 'es': 'es', 'fr': 'fr',
            'de': 'de', 'fa': 'fa', 'ha': 'ha', 'hi': 'hi',
            'it': 'it', 'pt': 'pt', 'pt-BR': 'pt', 'ru': 'ru',
            'vi': 'vi', 'zh': 'zh-CN', 'zh-CN': 'zh-CN',
            'zh-TW': 'zh-TW'
        }

    def _load_cache(self):
        try:
            return json.loads(self.cache_file.read_text(encoding='utf-8')) if self.cache_file.exists() else {}
        except:
            return {}

    def _save_cache(self):
        self.cache_file.write_text(json.dumps(self.cache, indent=2, ensure_ascii=False), encoding='utf-8')

    def translate_text(self, text: str, target_lang: str, source_lang: str = 'en') -> str:
        if not isinstance(text, str):
            return text

        cache_key = f"{source_lang}_{target_lang}_{text}"
        if cache_key in self.cache:
            return self.cache[cache_key]

        try:
            time.sleep(random.uniform(0.5, 1.0))
            translated = GoogleTranslator(
                source=source_lang,
                target=target_lang
            ).translate(text)
            self.cache[cache_key] = translated
            self._save_cache()
            return translated
        except Exception as e:
            print(f"⚠️ Failed to translate '{text}': {str(e)}")
            return text

    def process_file(self, config_file: str):
        try:
            with open(config_file, 'r', encoding='utf-8') as f:
                config = json.load(f)

            translations = config['translations']
            source_lang = config['source_language']
            target_langs = config['target_languages']
            file_format = config.get('file_format', 'php')
            filename = config.get('filename', 'translations')

            for lang in target_langs:
                print(f"\n🌐 Translating to {lang.upper()}")
                translated = {}

                # Handle both flat and nested structures
                if any(isinstance(v, dict) for v in translations.values()):
                    translated = self._translate_nested(translations, lang, source_lang)
                else:
                    for key, text in tqdm(translations.items(), desc="Translating"):
                        translated[key] = self.translate_text(text, lang, source_lang)

                self._save_translations(lang, translated, filename, file_format)

        except Exception as e:
            print(f"❌ Fatal error: {str(e)}")
            raise

    def _translate_nested(self, data: dict, target_lang: str, source_lang: str) -> dict:
        """Handle nested dictionary structures"""
        result = {}
        for key, value in tqdm(data.items(), desc="Processing nested"):
            if isinstance(value, dict):
                result[key] = self._translate_nested(value, target_lang, source_lang)
            else:
                result[key] = self.translate_text(value, target_lang, source_lang)
        return result

    def _save_translations(self, lang: str, translations: dict, filename: str, format: str):
        output_dir = Path(f"resources/lang/{lang}")
        output_dir.mkdir(parents=True, exist_ok=True)
        output_file = output_dir / f"{filename}.{format}"

        if format == 'php':
            content = self._generate_php(translations)
        else:
            content = json.dumps(translations, indent=2, ensure_ascii=False)

        output_file.write_text(content, encoding='utf-8')
        print(f"✅ Saved {output_file}")

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

if __name__ == '__main__':
    import sys
    if len(sys.argv) != 2:
        print("Usage: translator.py <config.json>")
        sys.exit(1)

    try:
        translator = LaravelTranslator()
        translator.process_file(sys.argv[1])
    except Exception as e:
        print(f"🔥 Critical error: {str(e)}")
        sys.exit(1)

