import json
import os
import sys
from PIL import Image, ImageDraw, ImageEnhance

def hex_to_rgb(hex_color):
    hex_color = hex_color.lstrip('#')
    lv = len(hex_color)
    return tuple(int(hex_color[i:i + lv // 3], 16) for i in range(0, lv, lv // 3))

def apply_corner_radius(im, radius):
    mask = Image.new('L', im.size, 0)
    draw = ImageDraw.Draw(mask)
    draw.rounded_rectangle([0, 0, im.size[0], im.size[1]], radius=radius, fill=255)
    im.putalpha(mask)
    return im

def add_margin(im, margin_ratio, bg_color):
    w, h = im.size
    margin = int(min(w, h) * margin_ratio)
    new_w, new_h = w + 2 * margin, h + 2 * margin
    bg = Image.new('RGBA', (new_w, new_h), bg_color)
    bg.paste(im, (margin, margin), im)
    return bg

def adjust_brightness(im, brightness):
    enhancer = ImageEnhance.Brightness(im)
    return enhancer.enhance(brightness)

# supported formats "blade", "plain", "laravel_mix", "vite"
def make_href(path, usage_format):
    if usage_format == "blade":
        return "{{ assetV('" + path + "') }}"
    elif usage_format == "laravel_mix":
        return "{{ mix('" + path + "') }}"
    elif usage_format == "vite":
        return "{{ Vite::assetV('" + path + "') }}"
    else:
        return "/" + path.lstrip("/")

def process_icon(config, icon_cfg, input_icon, output_dir, favicon_path, usage_lines, usage_format, dark=False):
    bg_color = icon_cfg.get("background", "#ffffff")
    margin = icon_cfg.get("margin", 0)
    corner_radius = icon_cfg.get("corner_radius", 0)
    color_overlay = icon_cfg.get("color_overlay")
    brightness = icon_cfg.get("brightness", 1.0)
    sizes = icon_cfg.get("sizes", [])

    try:
        img = Image.open(input_icon).convert("RGBA")
    except Exception as e:
        print(f"Error: Could not open input icon: {input_icon}")
        return

    for icon in sizes:
        size = icon["size"]
        filename = icon["filename"]
        export_path = os.path.join(output_dir, filename)
        try:
            icon_img = img.copy().resize((size, size), Image.LANCZOS)

            # Add background and margin
            if margin > 0:
                icon_img = add_margin(icon_img, margin, hex_to_rgb(bg_color) + (255,))

            # Apply corner radius
            if corner_radius > 0:
                radius = int(min(icon_img.size) * corner_radius)
                icon_img = apply_corner_radius(icon_img, radius)

            # Color overlay
            if color_overlay:
                overlay = Image.new("RGBA", icon_img.size, hex_to_rgb(color_overlay) + (128,))
                icon_img = Image.alpha_composite(icon_img, overlay)

            # Brightness
            if brightness != 1.0:
                icon_img = adjust_brightness(icon_img, brightness)

            # Save icon
            icon_img.save(export_path, "PNG")

            # Usage lines
            rel_path = os.path.join(favicon_path.lstrip('/'), filename)
            href = make_href(rel_path, usage_format)
            if dark:
                usage_lines.append(f'<link rel="icon" type="image/png" href="{href}" sizes="{size}x{size}" media="(prefers-color-scheme: dark)" />')
            else:
                if "apple-touch-icon" in filename:
                    usage_lines.append(f'<link rel="apple-touch-icon" sizes="{size}x{size}" href="{href}" />')
                else:
                    usage_lines.append(f'<link rel="icon" type="image/png" href="{href}" sizes="{size}x{size}" />')
        except Exception as e:
            print(f"Error: Failed to generate {filename}: {e}")

def generate_manifest(manifest_cfg, output_dir, favicon_path, usage_format):
    manifest = {
        "name": manifest_cfg.get("name", ""),
        "short_name": manifest_cfg.get("short_name", ""),
        "background_color": manifest_cfg.get("background_color", "#ffffff"),
        "theme_color": manifest_cfg.get("theme_color", "#222222"),
        "display": "standalone",
        "icons": []
    }
    for icon in manifest_cfg.get("icons", []):
        manifest["icons"].append({
            "src": "/" + icon["src"],
            "sizes": icon["sizes"],
            "type": icon["type"]
        })
    manifest_path = os.path.join(output_dir, "site.webmanifest")
    with open(manifest_path, "w") as f:
        json.dump(manifest, f, indent=2)
    href = make_href(os.path.join(favicon_path.lstrip("/"), "site.webmanifest"), usage_format)
    return f'<link rel="manifest" href="{href}" />'

def main():
    import platform
    try:
        import pyperclip
        clipboard_ok = True
    except ImportError:
        clipboard_ok = False

    if len(sys.argv) != 2:
        print("Usage: python favicon_generator.py config.json")
        sys.exit(1)

    with open(sys.argv[1], "r") as f:
        config = json.load(f)

    output_dir = config.get("output_dir", "public/icons")
    favicon_path = config.get("favicon_path", "/icons/")
    usage_format = config.get("usage_format", "plain")
    generate_usage_file = config.get("generate_usage_file", True)
    os.makedirs(output_dir, exist_ok=True)

    usage_lines = []

    # Regular icon
    process_icon(
        config,
        config["regular_icon"],
        config["input_icon"],
        output_dir,
        favicon_path,
        usage_lines,
        usage_format
    )

    # Dark icon
    dark_cfg = config.get("dark_icon", {})
    if dark_cfg.get("enabled"):
        process_icon(
            config,
            dark_cfg,
            dark_cfg.get("input_icon", config["input_icon"]),
            output_dir,
            favicon_path,
            usage_lines,
            usage_format,
            dark=True
        )

    # Apple Touch Icon
    process_icon(
        config,
        config["apple_touch_icon"],
        config["input_icon"],
        output_dir,
        favicon_path,
        usage_lines,
        usage_format
    )

    # Manifest
    manifest_cfg = config.get("manifest", {})
    if manifest_cfg.get("enabled"):
        usage_lines.append(generate_manifest(manifest_cfg, output_dir, favicon_path, usage_format))

    # Favicon.ico (multi-res)
    ico_sizes = [16, 32, 48]
    ico_imgs = []
    img = Image.open(config["input_icon"]).convert("RGBA")
    for size in ico_sizes:
        ico_imgs.append(img.resize((size, size), Image.LANCZOS))
    ico_path = os.path.join(output_dir, "favicon.ico")
    ico_imgs[0].save(ico_path, format='ICO', sizes=[(size, size) for size in ico_sizes])
    rel_path = os.path.join(favicon_path.lstrip('/'), "favicon.ico")
    href = make_href(rel_path, usage_format)
    usage_lines.append(f'<link rel="shortcut icon" href="{href}" />')

    # Write usage.txt
    if generate_usage_file:
        with open(os.path.join(output_dir, "usage.txt"), "w") as f:
            f.write('\n'.join(usage_lines))
        print("All icons generated. See usage.txt for HTML tags.")

    # Clipboard prompt
    if usage_lines:
        print("\nCopy usage HTML to clipboard? (yes/no): ", end="")
        answer = input().strip().lower()
        if answer in ("yes", "y"):
            if clipboard_ok:
                pyperclip.copy('\n'.join(usage_lines))
                print("Usage HTML copied to clipboard!")
            else:
                print("pyperclip not installed. Please install with 'pip install pyperclip' to enable clipboard support.")
                print("Here is the usage HTML:\n")
                print('\n'.join(usage_lines))

if __name__ == "__main__":
    main()
