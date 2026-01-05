---
title: SEO Foundation
version: "1.1"
status: deployed
project: SignShield
created: 2025-12-24
updated: 2025-12-24
---

# 1. Executive Summary

Implement foundational SEO for SignShield's public-facing pages (marketing website, public signing pages). This covers XML sitemap generation, robots.txt configuration, meta tags, canonical URLs, and search console integration. These are "quick wins" that establish the technical foundation for search engine visibility.

# 2. Current System State

## 2.1 Public-Facing Pages

| Page Type | URL Pattern | SEO Priority |
|-----------|-------------|--------------|
| Marketing homepage | signshield.io/ | High |
| Features page | signshield.io/features/ | High |
| Pricing page | signshield.io/pricing/ | High |
| About page | signshield.io/about/ | Medium |
| Contact page | signshield.io/contact/ | Medium |
| Terms of Service | signshield.io/terms/ | Low |
| Privacy Policy | signshield.io/privacy/ | Low |
| Public signing pages | *.signshield.io/sign/{token}/ | None (noindex) |
| Dashboard pages | *.signshield.io/dashboard/* | None (noindex) |

## 2.2 Current Gaps

- No XML sitemap
- No robots.txt
- No meta tags (title, description)
- No Open Graph / Twitter card tags
- No canonical URL tags
- No Google Search Console verification
- No structured data

# 3. Feature Requirements

## 3.1 XML Sitemap

Use Django's built-in sitemap framework to generate `/sitemap.xml`.

### Configuration

```python
# signshield/sitemaps.py

from django.contrib.sitemaps import Sitemap
from django.urls import reverse


class StaticViewSitemap(Sitemap):
    """Sitemap for static marketing pages."""

    priority = 0.8
    changefreq = 'weekly'
    protocol = 'https'

    def items(self):
        return [
            'home',
            'features',
            'pricing',
            'about',
            'contact',
            'terms',
            'privacy',
        ]

    def location(self, item):
        return reverse(item)

    def priority(self, item):
        # Higher priority for key conversion pages
        priorities = {
            'home': 1.0,
            'features': 0.9,
            'pricing': 0.9,
            'about': 0.7,
            'contact': 0.7,
            'terms': 0.3,
            'privacy': 0.3,
        }
        return priorities.get(item, 0.5)
```

### URL Configuration

```python
# urls.py

from django.contrib.sitemaps.views import sitemap
from signshield.sitemaps import StaticViewSitemap

sitemaps = {
    'static': StaticViewSitemap,
}

urlpatterns = [
    # ... existing urls ...

    path('sitemap.xml', sitemap, {'sitemaps': sitemaps},
         name='django.contrib.sitemaps.views.sitemap'),
]
```

### Settings

```python
# settings/base.py

INSTALLED_APPS = [
    # ... existing apps ...
    'django.contrib.sitemaps',
]

# Required for sitemap absolute URLs
SITE_ID = 1

# Or set explicitly
SITEMAP_PROTOCOL = 'https'
```

### Expected Output

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://signshield.io/</loc>
    <changefreq>weekly</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>https://signshield.io/features/</loc>
    <changefreq>weekly</changefreq>
    <priority>0.9</priority>
  </url>
  <!-- ... more URLs ... -->
</urlset>
```

## 3.2 robots.txt

Create a robots.txt file to control search engine crawling.

### Static File Approach (Recommended)

Create `static/robots.txt`:

```text
# robots.txt for signshield.io

User-agent: *
Allow: /
Disallow: /dashboard/
Disallow: /admin/
Disallow: /api/
Disallow: /sign/
Disallow: /accounts/

# Sitemap location
Sitemap: https://signshield.io/sitemap.xml
```

### URL Configuration

```python
# urls.py

from django.views.generic import TemplateView

urlpatterns = [
    # ... existing urls ...

    path('robots.txt', TemplateView.as_view(
        template_name='robots.txt',
        content_type='text/plain'
    ), name='robots'),
]
```

### Template Approach (for dynamic control)

Create `templates/robots.txt`:

```text
# robots.txt for signshield.io
# Generated dynamically

User-agent: *
Allow: /

# Private areas - do not index
Disallow: /dashboard/
Disallow: /admin/
Disallow: /api/
Disallow: /sign/
Disallow: /accounts/
Disallow: /webhooks/

# Sitemap
Sitemap: https://signshield.io/sitemap.xml
```

### Crawl Rules Explained

| Path | Rule | Reason |
|------|------|--------|
| / | Allow | Marketing pages should be indexed |
| /dashboard/ | Disallow | Private tenant areas |
| /admin/ | Disallow | Django admin |
| /api/ | Disallow | API endpoints |
| /sign/ | Disallow | Token-based signing pages (private) |
| /accounts/ | Disallow | Login, registration pages |
| /webhooks/ | Disallow | Webhook endpoints |

## 3.3 Meta Tags

### Base Template Meta Block

Update `templates/base.html` to include meta tag blocks:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO Meta Tags -->
    <title>{% block title %}SignShield - Video-Verified Digital Waivers{% endblock %}</title>
    <meta name="description" content="{% block meta_description %}SignShield provides video-verified digital waiver collection for businesses. Legally-binding electronic signatures with video consent.{% endblock %}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{% block canonical_url %}https://signshield.io{{ request.path }}{% endblock %}">

    <!-- Open Graph (Facebook, LinkedIn) -->
    <meta property="og:type" content="{% block og_type %}website{% endblock %}">
    <meta property="og:title" content="{% block og_title %}{{ block.super }}{% endblock %}">
    <meta property="og:description" content="{% block og_description %}{% block meta_description %}{% endblock %}{% endblock %}">
    <meta property="og:url" content="{% block og_url %}https://signshield.io{{ request.path }}{% endblock %}">
    <meta property="og:image" content="{% block og_image %}https://signshield.io/static/images/og-image.png{% endblock %}">
    <meta property="og:site_name" content="SignShield">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="{% block twitter_card %}summary_large_image{% endblock %}">
    <meta name="twitter:title" content="{% block twitter_title %}{% block og_title %}{% endblock %}{% endblock %}">
    <meta name="twitter:description" content="{% block twitter_description %}{% block meta_description %}{% endblock %}{% endblock %}">
    <meta name="twitter:image" content="{% block twitter_image %}https://signshield.io/static/images/og-image.png{% endblock %}">

    <!-- Additional SEO -->
    <meta name="robots" content="{% block robots %}index, follow{% endblock %}">
    <meta name="author" content="SignShield by EchoForgeX">

    {% block extra_head %}{% endblock %}
</head>
<body>
    {% block content %}{% endblock %}
</body>
</html>
```

### Page-Specific Meta Tags

**Homepage (templates/marketing/home.html):**

```html
{% extends "base.html" %}

{% block title %}SignShield - Video-Verified Digital Waivers for Your Business{% endblock %}

{% block meta_description %}Collect legally-binding digital waivers with video verification. SignShield helps businesses streamline waiver collection with electronic signatures and video consent.{% endblock %}

{% block content %}
<!-- Homepage content -->
{% endblock %}
```

**Features Page (templates/marketing/features.html):**

```html
{% extends "base.html" %}

{% block title %}Features - SignShield Digital Waiver Platform{% endblock %}

{% block meta_description %}Explore SignShield features: video-verified signatures, custom waiver templates, event management, automated reminders, and secure PDF storage.{% endblock %}

{% block content %}
<!-- Features content -->
{% endblock %}
```

**Pricing Page (templates/marketing/pricing.html):**

```html
{% extends "base.html" %}

{% block title %}Pricing - SignShield Digital Waiver Plans{% endblock %}

{% block meta_description %}Simple, transparent pricing for digital waiver collection. Free plan available. Starter at $29/mo, Professional at $79/mo, Enterprise at $199/mo.{% endblock %}

{% block content %}
<!-- Pricing content -->
{% endblock %}
```

### Meta Tags for Non-Indexed Pages

**Dashboard pages (templates/dashboard/base.html):**

```html
{% extends "base.html" %}

{% block robots %}noindex, nofollow{% endblock %}

{% block title %}Dashboard - {{ tenant.name }} | SignShield{% endblock %}
```

**Signing pages (templates/signing/sign.html):**

```html
{% extends "base.html" %}

{% block robots %}noindex, nofollow{% endblock %}

{% block title %}Sign Waiver | SignShield{% endblock %}
```

## 3.4 Canonical URLs

Canonical URLs prevent duplicate content issues when the same page is accessible via multiple URLs.

### Implementation

Already included in base template above:

```html
<link rel="canonical" href="{% block canonical_url %}https://signshield.io{{ request.path }}{% endblock %}">
```

### Special Cases

**Subdomain handling** - Marketing pages should always canonical to main domain:

```html
<!-- On any subdomain marketing page -->
{% block canonical_url %}https://signshield.io{{ request.path }}{% endblock %}
```

**Pagination** - If you have paginated content:

```html
{% block canonical_url %}https://signshield.io{{ request.path }}{% if page > 1 %}?page={{ page }}{% endif %}{% endblock %}
```

## 3.5 Open Graph Image

Create a default Open Graph image for social sharing.

### Image Specifications

| Attribute | Value |
|-----------|-------|
| Size | 1200 x 630 pixels |
| Format | PNG or JPG |
| File size | < 1 MB |
| Location | `/static/images/og-image.png` |

### Image Content Suggestions

```
┌─────────────────────────────────────────────────────────────────┐
│                                                                  │
│                      [SignShield Logo]                          │
│                                                                  │
│              Video-Verified Digital Waivers                     │
│                                                                  │
│         Collect legally-binding waivers with                    │
│            video consent verification                           │
│                                                                  │
│                    signshield.io                                │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

## 3.6 Structured Data (JSON-LD)

Add basic structured data for rich snippets in search results.

### Organization Schema

Add to `templates/base.html` (or marketing base):

```html
{% block structured_data %}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "SignShield",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "Web",
  "description": "Video-verified digital waiver collection platform for businesses",
  "url": "https://signshield.io",
  "provider": {
    "@type": "Organization",
    "name": "EchoForgeX",
    "url": "https://echoforgex.com"
  },
  "offers": {
    "@type": "AggregateOffer",
    "priceCurrency": "USD",
    "lowPrice": "0",
    "highPrice": "199",
    "offerCount": "4"
  }
}
</script>
{% endblock %}
```

### FAQ Schema (for FAQ pages)

If you have an FAQ section:

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is video-verified waiver signing?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Video-verified signing requires signers to record a brief video stating their name and consent, providing an additional layer of legal protection beyond traditional electronic signatures."
      }
    },
    {
      "@type": "Question",
      "name": "Are SignShield waivers legally binding?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, SignShield waivers comply with the ESIGN Act and UETA, making them legally binding electronic agreements in all 50 US states."
      }
    }
  ]
}
</script>
```

## 3.7 Google Search Console Setup

### Verification Steps

1. Go to https://search.google.com/search-console
2. Add property: `https://signshield.io`
3. Choose verification method (recommended: DNS TXT record)

### DNS Verification (in Cloudflare)

| Type | Name | Content |
|------|------|---------|
| TXT | @ | `google-site-verification=XXXXXXXXXXXXX` |

*(Google provides the exact value)*

### After Verification

1. **Submit sitemap:**
   - Go to Sitemaps section
   - Enter: `sitemap.xml`
   - Click Submit

2. **Request indexing:**
   - Use URL Inspection tool
   - Enter homepage URL
   - Click "Request Indexing"

3. **Monitor:**
   - Check Coverage report for errors
   - Review Performance for search queries
   - Check Core Web Vitals

## 3.8 Logo Implementation

The SignShield logo (shield with video camera, document, and checkmark) should appear consistently across all pages.

### Logo File Variants

Create multiple versions for different uses:

| File | Size | Use Case |
|------|------|----------|
| `logo-full.png` | 400x400 px | Full logo with "signshield.io" text |
| `logo-icon.png` | 200x200 px | Shield icon only (no text) |
| `logo-horizontal.png` | 300x80 px | Horizontal layout for headers |
| `logo-white.png` | 400x400 px | White version for dark backgrounds |
| `favicon.ico` | 32x32, 16x16 | Browser tab icon |
| `apple-touch-icon.png` | 180x180 px | iOS home screen |
| `og-image.png` | 1200x630 px | Social sharing (logo + tagline) |

**Location:** `/static/images/brand/`

### Header Logo Placement

```html
<!-- templates/base.html - Header -->
<header>
    <a href="{% url 'home' %}" class="logo-link">
        <img src="{% static 'images/brand/logo-horizontal.png' %}"
             alt="SignShield - Video-Verified Digital Waivers"
             class="logo"
             width="200"
             height="53">
    </a>
    <!-- Navigation -->
</header>
```

**Important SEO considerations:**
- Always include descriptive `alt` text
- Specify `width` and `height` to prevent layout shift (CLS)
- Link logo to homepage
- Use appropriate size variant for context

### Logo in Structured Data

Update the Organization schema to include the logo:

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "SignShield",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "Web",
  "description": "Video-verified digital waiver collection platform for businesses",
  "url": "https://signshield.io",
  "logo": "https://signshield.io/static/images/brand/logo-full.png",
  "image": "https://signshield.io/static/images/brand/logo-full.png",
  "provider": {
    "@type": "Organization",
    "name": "EchoForgeX",
    "url": "https://echoforgex.com",
    "logo": "https://echoforgex.com/static/images/logo.png"
  },
  "offers": {
    "@type": "AggregateOffer",
    "priceCurrency": "USD",
    "lowPrice": "0",
    "highPrice": "199",
    "offerCount": "4"
  }
}
</script>
```

### Email Logo

For email templates, use absolute URL:

```html
<!-- templates/emails/base.html -->
<div class="header">
    <img src="https://signshield.io/static/images/brand/logo-horizontal.png"
         alt="SignShield"
         width="150"
         style="max-width: 150px; height: auto;">
</div>
```

### Footer Logo

```html
<!-- templates/base.html - Footer -->
<footer>
    <div class="footer-brand">
        <img src="{% static 'images/brand/logo-icon.png' %}"
             alt="SignShield"
             width="40"
             height="40">
        <span>&copy; {% now "Y" %} SignShield by EchoForgeX</span>
    </div>
</footer>
```

## 3.9 Favicon & Touch Icons

Derive favicon from the logo shield icon:

```html
<!-- templates/base.html - Head -->
<link rel="icon" href="{% static 'images/brand/favicon.ico' %}" type="image/x-icon">
<link rel="icon" type="image/png" sizes="32x32" href="{% static 'images/brand/favicon-32x32.png' %}">
<link rel="icon" type="image/png" sizes="16x16" href="{% static 'images/brand/favicon-16x16.png' %}">
<link rel="apple-touch-icon" sizes="180x180" href="{% static 'images/brand/apple-touch-icon.png' %}">
<link rel="manifest" href="{% static 'site.webmanifest' %}">
<meta name="theme-color" content="#1a365d">
```

### Web Manifest

Create `/static/site.webmanifest`:

```json
{
    "name": "SignShield",
    "short_name": "SignShield",
    "icons": [
        {
            "src": "/static/images/brand/android-chrome-192x192.png",
            "sizes": "192x192",
            "type": "image/png"
        },
        {
            "src": "/static/images/brand/android-chrome-512x512.png",
            "sizes": "512x512",
            "type": "image/png"
        }
    ],
    "theme_color": "#1a365d",
    "background_color": "#ffffff",
    "display": "standalone"
}
```

## 3.10 Additional Quick Wins

### Heading Structure

Ensure proper H1-H6 hierarchy on each page:

```html
<!-- Good: One H1 per page, logical hierarchy -->
<h1>Video-Verified Digital Waivers</h1>
  <h2>Features</h2>
    <h3>Video Consent</h3>
    <h3>Electronic Signatures</h3>
  <h2>Pricing</h2>
    <h3>Free Plan</h3>
    <h3>Paid Plans</h3>
```

### Image Alt Text

All images should have descriptive alt text:

```html
<img src="/static/images/waiver-signing.png"
     alt="Person signing digital waiver on tablet with video recording">
```

### Internal Linking

Link between related pages:

```html
<!-- On features page -->
<p>Ready to get started? <a href="{% url 'pricing' %}">View our pricing plans</a>.</p>

<!-- On pricing page -->
<p>Learn more about our <a href="{% url 'features' %}">powerful features</a>.</p>
```

# 4. Future Considerations (Out of Scope)

- Blog/content marketing system
- Industry-specific landing pages (fitness waivers, adventure sports, etc.)
- Advanced structured data (Product, Review schemas)
- Local SEO (Google Business Profile)
- International SEO (hreflang tags)
- Core Web Vitals optimization
- Link building strategy

# 5. Implementation Approach

## 5.1 Recommended Phases

**Phase 1: Sitemap & robots.txt (30 minutes)**
1. Add `django.contrib.sitemaps` to INSTALLED_APPS
2. Create `sitemaps.py` with StaticViewSitemap
3. Add sitemap URL to urlpatterns
4. Create robots.txt template
5. Add robots.txt URL
6. Test both at /sitemap.xml and /robots.txt

**Phase 2: Meta Tags (1-2 hours)**
1. Update base.html with meta tag blocks
2. Add default meta content
3. Create page-specific meta for each marketing page
4. Add noindex to dashboard/signing pages
5. Test with browser dev tools

**Phase 3: Open Graph Image (30 minutes)**
1. Create 1200x630 OG image
2. Add to /static/images/
3. Update default og:image URL in templates

**Phase 4: Structured Data (30 minutes)**
1. Add Organization/SoftwareApplication schema to base
2. Validate with Google's Rich Results Test
3. Add FAQ schema if applicable

**Phase 5: Google Search Console (30 minutes)**
1. Create Search Console property
2. Add DNS verification record to Cloudflare
3. Verify ownership
4. Submit sitemap
5. Request indexing for key pages

## 5.2 Dependencies

| Dependency | Notes |
|------------|-------|
| marketing_website.md | Marketing pages must exist |
| deployment_infrastructure.md | DNS access for Search Console verification |
| Cloudflare | DNS TXT record for Google verification |

# 6. Acceptance Criteria

## 6.1 Sitemap

- [ ] /sitemap.xml returns valid XML
- [ ] All public marketing pages included
- [ ] Dashboard/signing pages excluded
- [ ] Priority values set appropriately
- [ ] Validates at xml-sitemaps.com/validate-xml-sitemap.html

## 6.2 robots.txt

- [ ] /robots.txt returns plain text
- [ ] Marketing pages allowed
- [ ] Dashboard, admin, API, signing pages disallowed
- [ ] Sitemap URL included
- [ ] Validates at Google Search Console robots.txt Tester

## 6.3 Meta Tags

- [ ] All marketing pages have unique title tags
- [ ] All marketing pages have unique meta descriptions
- [ ] Titles are 50-60 characters
- [ ] Descriptions are 150-160 characters
- [ ] Dashboard pages have noindex
- [ ] Signing pages have noindex

## 6.4 Open Graph

- [ ] og:title, og:description, og:image on all marketing pages
- [ ] OG image is 1200x630 pixels
- [ ] Preview correctly in Facebook Sharing Debugger
- [ ] Preview correctly in Twitter Card Validator

## 6.5 Canonical URLs

- [ ] All pages have canonical tag
- [ ] Canonicals point to https://signshield.io (not subdomain)
- [ ] No self-referencing issues

## 6.6 Structured Data

- [ ] JSON-LD schema in page source
- [ ] Validates in Google Rich Results Test
- [ ] No errors in Search Console

## 6.7 Google Search Console

- [ ] Property verified
- [ ] Sitemap submitted and processed
- [ ] No critical errors in Coverage report
- [ ] Key pages indexed (check with site:signshield.io)

## 6.8 Logo Implementation

- [ ] Logo file variants created (full, icon, horizontal, white)
- [ ] Logo placed in header on all pages
- [ ] Logo links to homepage
- [ ] Alt text is descriptive ("SignShield - Video-Verified Digital Waivers")
- [ ] Width/height attributes prevent layout shift
- [ ] Logo appears in footer
- [ ] Logo in email templates uses absolute URL
- [ ] Logo URL in structured data JSON-LD

## 6.9 Favicon & Touch Icons

- [ ] favicon.ico created (32x32, 16x16)
- [ ] apple-touch-icon.png created (180x180)
- [ ] Android chrome icons created (192x192, 512x512)
- [ ] site.webmanifest created
- [ ] Favicon visible in browser tab
- [ ] Theme color set (#1a365d - dark blue from logo)

---

# Changelog

## v1.1 - 2025-12-24
- Added Section 3.8: Logo Implementation
  - Logo file variants table
  - Header, footer, email logo placement
  - Logo in structured data
- Added Section 3.9: Favicon & Touch Icons
  - Favicon configuration
  - Web manifest for PWA
- Added acceptance criteria for logo and favicon

## v1.0 - 2025-12-24
- Initial specification for SEO foundation
- XML sitemap using Django sitemaps framework
- robots.txt configuration
- Meta tags with Open Graph and Twitter Cards
- Structured data with JSON-LD
- Google Search Console setup

---
*End of Specification*
