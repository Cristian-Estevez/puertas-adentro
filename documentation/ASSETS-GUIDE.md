# Assets Guide - Puertas Adentro

This guide explains how to organize and use static assets (images, CSS, JavaScript, fonts) in the Puertas Adentro application.

## 📁 Asset Directory Structure

```
puertas-adentro/
├── public/                    ← Apache Document Root (WEB ACCESSIBLE)
│   ├── assets/               ← ALL STATIC ASSETS GO HERE
│   │   ├── images/          ← Images (logos, photos, icons, backgrounds)
│   │   │   ├── logo.png
│   │   │   ├── hero-bg.jpg
│   │   │   ├── icons/
│   │   │   └── avatars/
│   │   ├── css/             ← Stylesheets
│   │   │   ├── app.css
│   │   │   ├── components.css
│   │   │   └── print.css
│   │   ├── js/              ← JavaScript files
│   │   │   ├── app.js
│   │   │   ├── components.js
│   │   │   └── vendor/
│   │   ├── fonts/           ← Web fonts
│   │   │   ├── custom-font.woff2
│   │   │   └── custom-font.woff
│   │   └── favicon.ico      ← Site favicon
│   ├── index.php
│   ├── login.php
│   └── logout.php
├── app/                      ← PROTECTED (not web accessible)
└── config/                   ← PROTECTED
```

## 🔒 Why This Structure?

### Security
- Only `public/` directory is web-accessible through Apache
- Assets are served directly by Apache (no PHP processing)
- Sensitive files in `app/` and `config/` remain protected

### Performance
- Direct file serving by Apache (faster than PHP)
- Browser caching works efficiently
- CDN-ready structure

### Organization
- Clear separation of static assets from application code
- Easy to find and manage assets
- Follows PSR-4 and modern PHP conventions

## 🛠️ Using Assets in Templates

### 1. Using the View Class Helper

```php
// In your templates, use the asset() method:
<img src="<?= $this->asset('images/logo.png') ?>" alt="Logo">
<link rel="stylesheet" href="<?= $this->asset('css/app.css') ?>">
<script src="<?= $this->asset('js/app.js') ?>"></script>
```

### 2. Direct URLs (Alternative)

```php
// You can also use direct URLs:
<img src="/assets/images/logo.png" alt="Logo">
<link rel="stylesheet" href="/assets/css/app.css">
```

## 📝 Asset Types and Examples

### Images (`public/assets/images/`)
- **Logos**: `logo.png`, `logo-white.png`
- **Backgrounds**: `hero-bg.jpg`, `pattern.png`
- **Icons**: `icons/user.svg`, `icons/settings.png`
- **Avatars**: `avatars/default.jpg`
- **UI Elements**: `buttons/submit.png`

### CSS (`public/assets/css/`)
- **Main styles**: `app.css`
- **Component styles**: `components.css`, `forms.css`
- **Print styles**: `print.css`
- **Vendor styles**: `vendor/bootstrap.css`

### JavaScript (`public/assets/js/`)
- **Main scripts**: `app.js`
- **Component scripts**: `components.js`, `forms.js`
- **Vendor scripts**: `vendor/jquery.js`

### Fonts (`public/assets/fonts/`)
- **Web fonts**: `custom-font.woff2`, `custom-font.woff`
- **Icon fonts**: `icons.woff2`

## 🎨 Example Usage in Templates

### Including CSS
```php
<!-- In layouts/main.php -->
<link rel="stylesheet" href="<?= $this->asset('css/app.css') ?>">
```

### Including JavaScript
```php
<!-- At the end of layouts/main.php -->
<script src="<?= $this->asset('js/app.js') ?>"></script>
```

### Using Images
```php
<!-- In any template -->
<img src="<?= $this->asset('images/logo.png') ?>" alt="Logo" class="logo">
<div class="hero" style="background-image: url('<?= $this->asset('images/hero-bg.jpg') ?>')">
```

### Using Icons
```php
<!-- SVG icons -->
<img src="<?= $this->asset('images/icons/user.svg') ?>" alt="User" class="icon">
```

## 🔧 Asset Management Best Practices

### 1. File Naming
- Use lowercase with hyphens: `hero-background.jpg`
- Be descriptive: `user-avatar-placeholder.png`
- Include dimensions for multiple sizes: `logo-200x50.png`

### 2. Organization
- Group related assets in subdirectories
- Use consistent naming conventions
- Keep file sizes optimized

### 3. Performance
- Optimize images (compress, use appropriate formats)
- Use WebP for modern browsers
- Consider lazy loading for images below the fold

### 4. Versioning (Future Enhancement)
```php
// For cache busting, you could add versioning:
public function asset(string $assetPath, string $version = null): string
{
    $url = $this->url('assets/' . ltrim($assetPath, '/'));
    return $version ? $url . '?v=' . $version : $url;
}
```

## 🚀 Adding New Assets

1. **Place the file** in the appropriate `public/assets/` subdirectory
2. **Reference it** in your templates using `$this->asset('path/to/file')`
3. **Test** that the asset loads correctly in the browser

## 📊 Asset URLs

When you use `$this->asset('images/logo.png')`, it generates:
- **Development**: `http://localhost/assets/images/logo.png`
- **Production**: `https://yourdomain.com/assets/images/logo.png`

## 🔍 Troubleshooting

### Asset Not Loading?
1. Check the file exists in `public/assets/`
2. Verify the path in your template
3. Check Apache is serving static files correctly
4. Look at browser developer tools for 404 errors

### Permission Issues?
```bash
# Set proper permissions
chmod 644 public/assets/images/*
chmod 644 public/assets/css/*
chmod 644 public/assets/js/*
```

This structure ensures your assets are secure, performant, and well-organized! 🎯
