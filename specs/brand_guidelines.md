---
title: Brand Guidelines
version: "1.0"
status: deployed
project: SignShield
created: 2025-01-17
updated: 2025-12-22
---

# 1. Executive Summary

Establish SignShield's visual identity system including colors, typography, spacing, and component styles. This spec serves as the foundation for all UI development across the marketing website, application dashboard, and public signing pages.

# 2. Current System State

## 2.1 Existing Assets

| Asset | Location | Status |
|-------|----------|--------|
| Logo (full) | To be added to `/static/images/logo.png` | Designed, needs export |
| Logo (icon only) | To be added to `/static/images/logo-icon.png` | Needs creation |
| Favicon | To be added to `/static/favicon.ico` | Needs creation |

## 2.2 Current Gaps

- No defined color palette
- No typography system
- No component library
- No spacing/sizing standards
- Inconsistent styling across existing templates

# 3. Brand Identity

## 3.1 Logo Usage

### Primary Logo
The SignShield logo consists of:
- **Shield icon**: Dark navy shield with video camera, document, and checkmark
- **Wordmark**: "signshield.io" with "sign" in royal blue, "shield.io" in slate gray

### Logo Variants

| Variant | Use Case | Background |
|---------|----------|------------|
| Full color | Primary use, marketing, dashboard header | Light backgrounds |
| Reversed | Dark backgrounds, footer | Dark backgrounds |
| Icon only | Favicon, mobile nav, app icon | Any |
| Monochrome | Legal documents, PDFs | Any |

### Clear Space
Minimum clear space around logo: Height of the "s" in "signshield" on all sides.

### Minimum Sizes
- Full logo: 120px wide minimum
- Icon only: 32px minimum

## 3.2 Color Palette

### Primary Colors

| Name | Hex | RGB | Usage |
|------|-----|-----|-------|
| **Navy** | `#1E2A3B` | 30, 42, 59 | Primary dark, headers, text |
| **Royal Blue** | `#2D7DD2` | 45, 125, 210 | Primary accent, CTAs, links |
| **Slate** | `#5A6978` | 90, 105, 120 | Secondary text, "shield.io" |

### Secondary Colors

| Name | Hex | RGB | Usage |
|------|-----|-----|-------|
| **Sky Blue** | `#4A9FE8` | 74, 159, 232 | Hover states, highlights |
| **Light Blue** | `#E8F4FC` | 232, 244, 252 | Backgrounds, cards |
| **Ice** | `#F5F9FC` | 245, 249, 252 | Page backgrounds |

### Semantic Colors

| Name | Hex | Usage |
|------|-----|-------|
| **Success** | `#059669` | Confirmations, completed states |
| **Success Light** | `#D1FAE5` | Success backgrounds |
| **Warning** | `#D97706` | Warnings, pending states |
| **Warning Light** | `#FEF3C7` | Warning backgrounds |
| **Error** | `#DC2626` | Errors, destructive actions |
| **Error Light** | `#FEE2E2` | Error backgrounds |
| **Info** | `#2D7DD2` | Informational (uses Royal Blue) |
| **Info Light** | `#E8F4FC` | Info backgrounds (uses Light Blue) |

### Neutral Colors

| Name | Hex | Usage |
|------|-----|-------|
| **Gray 900** | `#111827` | Headings |
| **Gray 700** | `#374151` | Body text |
| **Gray 500** | `#6B7280` | Secondary text, placeholders |
| **Gray 300** | `#D1D5DB` | Borders, dividers |
| **Gray 100** | `#F3F4F6` | Backgrounds, disabled states |
| **White** | `#FFFFFF` | Cards, inputs, primary backgrounds |

## 3.3 Typography

### Font Stack

```css
/* Primary font - clean, professional, excellent readability */
--font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;

/* Monospace - for code, tokens, technical content */
--font-mono: 'JetBrains Mono', 'Fira Code', 'Consolas', monospace;
```

### Font Loading
Include Inter from Google Fonts:
```html
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
```

### Type Scale

| Name | Size | Weight | Line Height | Usage |
|------|------|--------|-------------|-------|
| **Display** | 48px / 3rem | 700 | 1.1 | Hero headlines |
| **H1** | 36px / 2.25rem | 700 | 1.2 | Page titles |
| **H2** | 30px / 1.875rem | 600 | 1.25 | Section headers |
| **H3** | 24px / 1.5rem | 600 | 1.3 | Subsection headers |
| **H4** | 20px / 1.25rem | 600 | 1.4 | Card titles |
| **Body Large** | 18px / 1.125rem | 400 | 1.6 | Lead paragraphs |
| **Body** | 16px / 1rem | 400 | 1.6 | Default body text |
| **Body Small** | 14px / 0.875rem | 400 | 1.5 | Secondary text, captions |
| **Caption** | 12px / 0.75rem | 500 | 1.4 | Labels, badges |

## 3.4 Spacing System

Use a 4px base unit with the following scale:

| Token | Value | Usage |
|-------|-------|-------|
| `--space-1` | 4px | Tight spacing, icon gaps |
| `--space-2` | 8px | Compact elements |
| `--space-3` | 12px | Form field padding |
| `--space-4` | 16px | Default padding |
| `--space-5` | 20px | Card padding |
| `--space-6` | 24px | Section gaps |
| `--space-8` | 32px | Large gaps |
| `--space-10` | 40px | Section margins |
| `--space-12` | 48px | Large section margins |
| `--space-16` | 64px | Page sections |
| `--space-20` | 80px | Hero sections |

## 3.5 Border Radius

| Token | Value | Usage |
|-------|-------|-------|
| `--radius-sm` | 4px | Badges, small elements |
| `--radius-md` | 6px | Buttons, inputs |
| `--radius-lg` | 8px | Cards, modals |
| `--radius-xl` | 12px | Large cards, panels |
| `--radius-full` | 9999px | Pills, avatars |

## 3.6 Shadows

```css
--shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
--shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
--shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
--shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
```

# 4. Component Styles

## 4.1 Buttons

### Primary Button
```css
.btn-primary {
    background: var(--color-royal-blue);  /* #2D7DD2 */
    color: white;
    padding: 12px 24px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 16px;
    transition: background 150ms ease;
}
.btn-primary:hover {
    background: #2568B3;  /* Darker shade */
}
.btn-primary:focus {
    outline: 2px solid var(--color-royal-blue);
    outline-offset: 2px;
}
```

### Secondary Button
```css
.btn-secondary {
    background: white;
    color: var(--color-navy);
    border: 1px solid var(--color-gray-300);
    padding: 12px 24px;
    border-radius: 6px;
    font-weight: 600;
}
.btn-secondary:hover {
    background: var(--color-gray-100);
    border-color: var(--color-gray-400);
}
```

### Button Sizes

| Size | Padding | Font Size |
|------|---------|-----------|
| Small | 8px 16px | 14px |
| Medium (default) | 12px 24px | 16px |
| Large | 16px 32px | 18px |

## 4.2 Form Inputs

```css
.input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--color-gray-300);
    border-radius: 6px;
    font-size: 16px;
    transition: border-color 150ms ease, box-shadow 150ms ease;
}
.input:focus {
    border-color: var(--color-royal-blue);
    box-shadow: 0 0 0 3px rgba(45, 125, 210, 0.1);
    outline: none;
}
.input::placeholder {
    color: var(--color-gray-500);
}
.input.error {
    border-color: var(--color-error);
}
```

## 4.3 Cards

```css
.card {
    background: white;
    border-radius: 8px;
    box-shadow: var(--shadow-md);
    padding: 24px;
}
.card-elevated {
    box-shadow: var(--shadow-lg);
}
.card-bordered {
    box-shadow: none;
    border: 1px solid var(--color-gray-300);
}
```

## 4.4 Links

```css
a {
    color: var(--color-royal-blue);
    text-decoration: none;
    transition: color 150ms ease;
}
a:hover {
    color: #2568B3;
    text-decoration: underline;
}
```

## 4.5 Badges

```css
.badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 500;
}
.badge-success {
    background: var(--color-success-light);
    color: var(--color-success);
}
.badge-warning {
    background: var(--color-warning-light);
    color: var(--color-warning);
}
.badge-error {
    background: var(--color-error-light);
    color: var(--color-error);
}
```

# 5. Layout Standards

## 5.1 Container Widths

| Name | Max Width | Usage |
|------|-----------|-------|
| Narrow | 640px | Auth pages, forms |
| Default | 1024px | Content pages |
| Wide | 1280px | Dashboard, marketing |
| Full | 100% | Edge-to-edge sections |

## 5.2 Responsive Breakpoints

| Name | Min Width | Usage |
|------|-----------|-------|
| `sm` | 640px | Large phones, small tablets |
| `md` | 768px | Tablets |
| `lg` | 1024px | Small laptops |
| `xl` | 1280px | Desktops |
| `2xl` | 1536px | Large screens |

## 5.3 Grid System

Use CSS Grid with 12 columns:
```css
.grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 24px;
}
```

# 6. Implementation

## 6.1 CSS Variables File

Create `/static/css/variables.css` containing all design tokens as CSS custom properties.

## 6.2 Base Styles File

Create `/static/css/base.css` with:
- CSS reset/normalize
- Typography defaults
- Component classes
- Utility classes

## 6.3 File Structure

```
static/
├── css/
│   ├── variables.css      # Design tokens
│   ├── base.css           # Reset, typography, components
│   ├── utilities.css      # Utility classes
│   └── main.css           # Imports all above
├── images/
│   ├── logo.png           # Full logo
│   ├── logo-icon.png      # Icon only
│   ├── logo-white.png     # Reversed for dark backgrounds
│   └── og-image.png       # Social sharing image
└── favicon.ico
```

# 7. Acceptance Criteria

## 7.1 Design Tokens

- [ ] All color variables defined in CSS
- [ ] Typography scale implemented
- [ ] Spacing scale implemented
- [ ] Border radius tokens defined
- [ ] Shadow tokens defined

## 7.2 Component Styles

- [ ] Button styles (primary, secondary, sizes)
- [ ] Form input styles (default, focus, error states)
- [ ] Card styles (default, elevated, bordered)
- [ ] Badge styles (success, warning, error, info)
- [ ] Link styles with hover states

## 7.3 Assets

- [ ] Logo files exported and placed in static/images/
- [ ] Favicon created and placed
- [ ] Open Graph image created for social sharing

## 7.4 Documentation

- [ ] CSS files well-commented
- [ ] Variables file serves as living documentation

---
*End of Specification*
