# CLAUDE.md

This file provides guidance to Claude Code when working with the EchoForgeX website project.

## Project Overview

EchoForgeX.com is a WordPress-based marketing and blog website for EchoForgeX LLC, an AI-focused software studio. The site showcases products (SignShield, AI Workforce), services, and company blog.

## Tech Stack

- **CMS:** WordPress 6.x
- **Theme:** GeneratePress Premium with custom child theme
- **Page Builder:** GenerateBlocks Pro
- **SEO:** RankMath Pro
- **Forms:** WPForms
- **Caching:** WP Super Cache + Redis
- **Security:** Wordfence

## Specification

The full specification is located at:
```
../signshield/docs/specs/echoforgex_website.md
```

This spec contains:
- Site architecture and page structure
- Design system (colors, typography, components)
- WordPress plugin requirements
- Server configuration (Nginx)
- SEO and performance requirements
- Implementation phases

## Directory Structure

```
echoforgex-website/
├── wp-content/
│   ├── themes/
│   │   └── echoforgex-theme/    # Child theme (GeneratePress child)
│   │       ├── style.css        # Theme styles + child theme header
│   │       ├── functions.php    # Theme functions
│   │       └── assets/          # Theme assets
│   └── plugins/                  # Custom plugins (if needed)
├── docs/                         # Local documentation
├── assets/                       # Source assets (not deployed)
│   ├── logos/
│   ├── images/
│   └── fonts/
└── README.md
```

## Server Paths

**Local Development:**
- This repo contains theme customizations and assets
- WordPress core is NOT version controlled

**Production Server (Linode):**

| Setting | Value |
|---------|-------|
| SSH Host | 198.58.119.160 |
| SSH User | deploy |
| SSH Connection | `deploy@198.58.119.160` |
| WordPress Path | /var/www/echoforgex.com/public_html |
| Theme Path | /var/www/echoforgex.com/public_html/wp-content/themes/echoforgex-theme |
| Logs | /var/www/echoforgex.com/logs |
| Backups | /var/www/echoforgex.com/backups |

```
/var/www/echoforgex.com/
├── public_html/          # WordPress installation
│   ├── wp-content/
│   │   ├── themes/echoforgex-theme/  # Deploy theme here
│   │   └── ...
│   └── ...
├── logs/
└── backups/
```

## Design System

### Brand Colors

| Name | Hex | Usage |
|------|-----|-------|
| Navy Dark | #0A1628 | Background |
| Navy Medium | #1A2744 | Cards |
| Blue Primary | #2D7DD2 | CTAs, links |
| Blue Light | #4A9BE8 | Hover states |
| Cyan Accent | #00C2FF | Gradient end |

### Typography

- **Headings:** Inter, 600-700 weight
- **Body:** Inter, 400 weight
- **Code:** JetBrains Mono

## Common Tasks

### Theme Development

The child theme extends GeneratePress. Edit files in:
```
wp-content/themes/echoforgex-theme/
```

### Adding Custom CSS

Add to `style.css` or create separate files and enqueue in `functions.php`.

### Deploying Theme Changes

1. Make changes locally in `wp-content/themes/echoforgex-theme/`
2. SFTP/rsync to server: `/var/www/echoforgex.com/public_html/wp-content/themes/echoforgex-theme/`

## Related Projects

- **SignShield:** `../signshield/` - Django app on same server
- **Specs:** `../signshield/docs/specs/` - All project specifications

## Important Notes

- WordPress core files are NOT in this repo
- Only theme customizations and source assets are version controlled
- Server configuration (Nginx) is in the spec, applied directly on Linode
- Database is MySQL (separate from SignShield's PostgreSQL)
