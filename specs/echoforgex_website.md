---
title: EchoForgeX Marketing Website
version: "1.0"
status: in-development
project: EchoForgeX Website
created: 2025-12-25
updated: 2025-12-25
---

# 1. Executive Summary

Build the EchoForgeX.com marketing and blog website—a WordPress-based site showcasing EchoForgeX LLC as an AI-focused software studio and product company. The site will feature the product portfolio (SignShield live, AI Workforce coming soon), custom AI services offerings, a team blog, and lead generation capabilities. Hosted on the same Linode server as SignShield but as a separate WordPress installation.

# 2. Company Overview

## 2.1 About EchoForgeX

**EchoForgeX LLC** is a software studio and product holding company specializing in AI-powered solutions.

**Positioning Statement:**
> We forge intelligent software products and help businesses harness AI to transform their operations.

**Current Products:**
| Product | Status | Description |
|---------|--------|-------------|
| SignShield | Live | Video-verified digital waiver platform |
| AI Workforce | In Development | On-demand AI agent workforce platform |

**Services Offered:**
- Custom AI development
- AI strategy consulting
- AI integration services

**Target Audience:**
- Potential clients (businesses seeking AI solutions)
- Investors

## 2.2 AI Workforce Concept (Teaser)

**Tagline:** "Your On-Demand AI Team"

**Concept:**
- Hire AI agents when you need them, release when you don't
- No long-term commitments—scale workforce up or down instantly
- AI Executive Assistant manages "hiring" of specialized agents
- Pay only for what you use

**Messaging for Teaser Page:**
> Imagine having a skilled workforce at your fingertips. AI Workforce lets you hire specialized AI agents on demand—from data analysts to content creators to customer support. Your AI Executive Assistant handles the staffing, so you can focus on results.

# 3. Technical Architecture

## 3.1 Infrastructure Overview

```
┌─────────────────────────────────────────────────────────────┐
│                      Cloudflare                              │
│                    (DNS + CDN + SSL)                         │
├──────────────────────────┬──────────────────────────────────┤
│                          │                                   │
│    echoforgex.com        │     signshield.io                │
│    www.echoforgex.com    │     *.signshield.io              │
│                          │                                   │
└──────────────────────────┴──────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                     Linode Server                            │
│                                                              │
│  ┌─────────────────────────────────────────────────────┐    │
│  │                      Nginx                           │    │
│  │              (Reverse Proxy + SSL)                   │    │
│  └─────────────────────────────────────────────────────┘    │
│           │                              │                   │
│           ▼                              ▼                   │
│  ┌─────────────────┐          ┌─────────────────────┐       │
│  │   WordPress     │          │      Django         │       │
│  │  (PHP-FPM)      │          │     (Gunicorn)      │       │
│  │                 │          │                     │       │
│  │  echoforgex.com │          │  signshield.io      │       │
│  │                 │          │                     │       │
│  └────────┬────────┘          └──────────┬──────────┘       │
│           │                              │                   │
│           ▼                              ▼                   │
│  ┌─────────────────┐          ┌─────────────────────┐       │
│  │     MySQL       │          │    PostgreSQL       │       │
│  │  (WordPress DB) │          │   (SignShield DB)   │       │
│  └─────────────────┘          └─────────────────────┘       │
│                                                              │
│  Shared: Redis (caching), Certbot (SSL), fail2ban           │
└─────────────────────────────────────────────────────────────┘
```

## 3.2 WordPress Stack

| Component | Choice | Rationale |
|-----------|--------|-----------|
| **WordPress Version** | 6.x (latest) | Modern block editor, security |
| **PHP Version** | 8.2+ | Performance, security |
| **Database** | MySQL 8.0 | Standard WP database |
| **Web Server** | Nginx + PHP-FPM | Performance, same as SignShield |
| **SSL** | Cloudflare + Let's Encrypt | Free, auto-renewal |
| **Caching** | Redis Object Cache + WP Super Cache | Speed |

## 3.3 WordPress Plugins

### Required Plugins

| Plugin | Purpose | Notes |
|--------|---------|-------|
| **GeneratePress Premium** | Theme | Lightweight, customizable |
| **GenerateBlocks Pro** | Page Builder | Works with theme, no bloat |
| **RankMath Pro** | SEO | Schema, sitemap, analytics |
| **WPForms** | Contact Forms | Conditional logic, integrations |
| **Wordfence** | Security | Firewall, malware scan |
| **WP Super Cache** | Page Caching | Performance |
| **Redis Object Cache** | Database Caching | Performance |
| **UpdraftPlus** | Backups | Scheduled backups to cloud |

### Optional Plugins

| Plugin | Purpose | Notes |
|--------|---------|-------|
| **Social Warfare** | Social Sharing | Blog post sharing |
| **Reading Time WP** | Reading Time | Blog enhancement |
| **Jepack** (Minimal) | Site stats only | Lightweight analytics |

## 3.4 Domain & DNS Configuration

**Cloudflare DNS Records:**

| Type | Name | Value | Proxy |
|------|------|-------|-------|
| A | echoforgex.com | [Linode IP] | Proxied |
| A | www | [Linode IP] | Proxied |
| MX | @ | mail.echoforgex.com | DNS only |
| TXT | @ | v=spf1 include:_spf.hostinger.com ~all | DNS only |
| CNAME | mail | [Hostinger mail server] | DNS only |

**Nginx Server Block:**

```nginx
# /etc/nginx/sites-available/echoforgex.com
server {
    listen 80;
    server_name echoforgex.com www.echoforgex.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name echoforgex.com www.echoforgex.com;

    root /var/www/echoforgex.com/public_html;
    index index.php index.html;

    # SSL via Cloudflare (Origin Certificate)
    ssl_certificate /etc/ssl/cloudflare/echoforgex.com.pem;
    ssl_certificate_key /etc/ssl/cloudflare/echoforgex.com.key;

    # WordPress permalinks
    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    # PHP handling
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Security
    location ~ /\.ht {
        deny all;
    }

    location = /wp-config.php {
        deny all;
    }

    # Static file caching
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2)$ {
        expires 30d;
        add_header Cache-Control "public, immutable";
    }
}
```

# 4. Site Structure & Pages

## 4.1 Information Architecture

```
echoforgex.com/
│
├── /                           # Home
├── /about/                     # About EchoForgeX
│   └── Team section            # (on same page or separate)
│
├── /products/                  # Product Portfolio
│   ├── /products/signshield/   # SignShield product page
│   └── /products/ai-workforce/ # AI Workforce teaser
│
├── /services/                  # AI Services
│   ├── AI Strategy section
│   ├── Custom Development section
│   └── Integration Services section
│
├── /blog/                      # Blog listing
│   ├── /blog/category/{slug}/  # Category archives
│   ├── /blog/author/{slug}/    # Author archives
│   └── /blog/{post-slug}/      # Individual posts
│
├── /contact/                   # Contact + Booking
│
├── /privacy/                   # Privacy Policy
├── /terms/                     # Terms of Service
│
└── /newsletter-thanks/         # Newsletter confirmation
```

## 4.2 Page Specifications

### Home Page

**Purpose:** First impression, value proposition, guide to key areas

**Sections:**

```
┌─────────────────────────────────────────────────────────────┐
│  [Logo]              About | Products | Services | Blog | Contact │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│           ⚒️ [Anvil Icon with Waves]                        │
│                                                              │
│              Forging the Future of                          │
│            AI-Powered Software                              │
│                                                              │
│    We build intelligent products and help businesses        │
│    harness AI to transform their operations.                │
│                                                              │
│       [Explore Our Products]    [Work With Us]              │
│                                                              │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│                    OUR PRODUCTS                              │
│                                                              │
│   ┌─────────────────────┐   ┌─────────────────────┐        │
│   │                     │   │                     │        │
│   │     SignShield      │   │    AI Workforce     │        │
│   │     [SS Logo]       │   │    [Coming Soon]    │        │
│   │                     │   │                     │        │
│   │  Video-verified     │   │  On-demand AI       │        │
│   │  digital waivers    │   │  agents at your     │        │
│   │  for businesses     │   │  fingertips         │        │
│   │                     │   │                     │        │
│   │   [Learn More →]    │   │   [Get Notified →]  │        │
│   │                     │   │                     │        │
│   └─────────────────────┘   └─────────────────────┘        │
│                                                              │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│                    OUR SERVICES                              │
│                                                              │
│   AI Strategy    │    Custom AI Dev    │    Integration     │
│   ─────────────      ─────────────        ─────────────     │
│   Chart your AI      Build custom AI      Connect AI to     │
│   roadmap with       solutions for        your existing     │
│   expert guidance    your unique needs    systems           │
│                                                              │
│                   [Explore Services →]                       │
│                                                              │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│                  LATEST FROM THE BLOG                        │
│                                                              │
│   [Post Card 1]    [Post Card 2]    [Post Card 3]           │
│                                                              │
│                    [View All Posts →]                        │
│                                                              │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│                    STAY IN THE LOOP                          │
│                                                              │
│    Get updates on our products and AI insights              │
│                                                              │
│    [First Name]  [Email Address]  [Subscribe]               │
│                                                              │
│    We respect your privacy. Unsubscribe anytime.            │
│                                                              │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│   [Logo]                                                     │
│                                                              │
│   Products: SignShield | AI Workforce                       │
│   Company: About | Services | Blog | Contact                │
│   Legal: Privacy Policy | Terms of Service                  │
│                                                              │
│   © 2025 EchoForgeX LLC. All rights reserved.               │
│                                                              │
│   [LinkedIn] [Twitter/X] [GitHub]                           │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

### About Page

**Purpose:** Company story, team, values, build trust

**Sections:**
1. **Hero:** "Who We Are" with brief intro
2. **Our Story:** Founding story, mission
3. **Our Values:** Key principles (3-4 values)
4. **The Team:** Team member cards with photos, titles, brief bios
5. **CTA:** "Ready to work together?" → Contact

### Products Page

**Purpose:** Showcase product portfolio

**Sections:**
1. **Hero:** "Our Products" intro
2. **SignShield Card:** Logo, description, key features, link to signshield.io
3. **AI Workforce Card:** Teaser, "Coming Soon," email capture for notifications
4. **CTA:** "Have a product idea?" → Contact for custom development

### SignShield Product Page (/products/signshield/)

**Purpose:** Detailed product information, drive traffic to signshield.io

**Sections:**
1. **Hero:** SignShield logo + tagline
2. **Problem/Solution:** Why video-verified waivers matter
3. **Key Features:** 4-6 feature blocks with icons
4. **How It Works:** 3-step process
5. **Who It's For:** Target industries (fitness, adventure, events)
6. **CTA:** "Try SignShield Free" → signshield.io/signup

### AI Workforce Teaser Page (/products/ai-workforce/)

**Purpose:** Generate interest, capture leads for launch

**Sections:**
1. **Hero:** "Coming Soon" badge + concept intro
2. **The Vision:** Explanation of on-demand AI workforce
3. **How It Will Work:** Concept flow (hire → work → release)
4. **Use Cases:** Example scenarios
5. **Email Capture:** "Be the first to know" form
6. **FAQ:** Common questions about the concept

### Services Page

**Purpose:** Showcase consulting/custom development offerings

**Sections:**
1. **Hero:** "AI Services" intro
2. **Service Cards:**
   - **AI Strategy Consulting:** Roadmap, assessment, recommendations
   - **Custom AI Development:** Bespoke AI solutions, integration
   - **AI Integration:** Connect AI to existing systems
3. **Our Approach:** Process overview (Discovery → Design → Build → Support)
4. **CTA:** "Let's discuss your project" → Contact

### Blog

**Purpose:** Content marketing, SEO, thought leadership

**Features:**
- Post listing with featured images
- Categories (AI Trends, Product Updates, Technical Insights, Company News)
- Author profiles with photos and bios
- Related posts at end of articles
- Social sharing buttons
- Estimated reading time
- Newsletter signup in sidebar/footer

**Post Template Sections:**
1. Featured image (16:9 ratio)
2. Title + meta (author, date, reading time, category)
3. Content
4. Author bio box
5. Related posts (3)
6. Newsletter CTA

### Contact Page

**Purpose:** Lead capture, booking calls

**Sections:**
1. **Hero:** "Let's Talk"
2. **Contact Form:**
   - First Name* (required)
   - Last Name*
   - Email* (required)
   - Phone* (required)
   - Company Name
   - Project Type (dropdown: AI Strategy, Custom Development, Integration, Other)
   - Budget Range (dropdown: <$10K, $10-25K, $25-50K, $50-100K, $100K+)
   - Message*
   - How did you hear about us? (dropdown)
3. **Book a Call:** Calendly embed for scheduling
4. **Direct Contact:** Email address, response time expectation
5. **Location:** "Based in [City], working with clients worldwide"

# 5. Design System

## 5.1 Brand Colors

**Primary Palette (from logo):**

| Name | Hex | Usage |
|------|-----|-------|
| Navy (Dark) | #0A1628 | Background, dark sections |
| Navy (Medium) | #1A2744 | Cards, secondary backgrounds |
| Blue (Primary) | #2D7DD2 | CTAs, links, accents |
| Blue (Light) | #4A9BE8 | Hover states, gradients |
| Cyan (Accent) | #00C2FF | Gradient end, highlights |

**Neutral Palette:**

| Name | Hex | Usage |
|------|-----|-------|
| White | #FFFFFF | Text on dark, backgrounds |
| Gray 100 | #F8FAFC | Light backgrounds |
| Gray 300 | #CBD5E1 | Borders, dividers |
| Gray 500 | #64748B | Secondary text |
| Gray 700 | #334155 | Body text (light mode) |
| Gray 900 | #0F172A | Headings (light mode) |

**Gradient:**
```css
.brand-gradient {
    background: linear-gradient(135deg, #2D7DD2 0%, #00C2FF 100%);
}
```

## 5.2 Typography

**Font Stack:**

| Element | Font | Weight | Size |
|---------|------|--------|------|
| Headings | Inter | 600-700 | 32-64px |
| Body | Inter | 400 | 16-18px |
| Navigation | Inter | 500 | 14-16px |
| Code/Mono | JetBrains Mono | 400 | 14px |

**Type Scale:**
```css
:root {
    --text-xs: 0.75rem;    /* 12px */
    --text-sm: 0.875rem;   /* 14px */
    --text-base: 1rem;     /* 16px */
    --text-lg: 1.125rem;   /* 18px */
    --text-xl: 1.25rem;    /* 20px */
    --text-2xl: 1.5rem;    /* 24px */
    --text-3xl: 1.875rem;  /* 30px */
    --text-4xl: 2.25rem;   /* 36px */
    --text-5xl: 3rem;      /* 48px */
    --text-6xl: 3.75rem;   /* 60px */
}
```

## 5.3 Component Styles

### Buttons

```css
/* Primary Button */
.btn-primary {
    background: linear-gradient(135deg, #2D7DD2 0%, #4A9BE8 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(45, 125, 210, 0.4);
}

/* Secondary Button */
.btn-secondary {
    background: transparent;
    color: #2D7DD2;
    border: 2px solid #2D7DD2;
    padding: 10px 22px;
    border-radius: 8px;
}

.btn-secondary:hover {
    background: rgba(45, 125, 210, 0.1);
}
```

### Cards

```css
.card {
    background: #1A2744;
    border-radius: 12px;
    padding: 24px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.card:hover {
    border-color: rgba(45, 125, 210, 0.5);
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}
```

### Form Inputs

```css
.form-input {
    background: #0A1628;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    padding: 12px 16px;
    color: white;
    width: 100%;
}

.form-input:focus {
    outline: none;
    border-color: #2D7DD2;
    box-shadow: 0 0 0 3px rgba(45, 125, 210, 0.2);
}
```

## 5.4 Design References

**Inspiration Sources:**

| Site | What to Borrow |
|------|---------------|
| [Linear](https://linear.app) | Dark theme, clean layout, subtle motion |
| [37signals](https://37signals.com) | Minimalism, content clarity, values display |
| [Vercel](https://vercel.com) | Technical precision, developer credibility |
| [Anthropic](https://anthropic.com) | Approachable AI messaging, trust building |
| [Raycast](https://raycast.com) | Product demos, gradient usage, premium feel |

## 5.5 Logo Assets

**Logo Variants Needed:**

| Variant | Format | Usage |
|---------|--------|-------|
| Full Logo (horizontal) | SVG, PNG | Header, light backgrounds |
| Full Logo (stacked) | SVG, PNG | Footer, mobile |
| Icon Only (anvil) | SVG, PNG, ICO | Favicon, app icon |
| White version | SVG, PNG | Dark backgrounds |
| Dark version | SVG, PNG | Light backgrounds |

**Favicon Sizes:**
- favicon.ico (16x16, 32x32)
- apple-touch-icon.png (180x180)
- icon-192.png (192x192)
- icon-512.png (512x512)

# 6. Blog Configuration

## 6.1 Categories

| Category | Slug | Description |
|----------|------|-------------|
| AI Trends | ai-trends | Industry insights, AI developments |
| Product Updates | product-updates | SignShield, AI Workforce news |
| Technical | technical | How-tos, deep dives, tutorials |
| Company News | company-news | Announcements, milestones |

## 6.2 Author Profiles

**Fields per Author:**
- Display Name
- Title/Role
- Bio (2-3 sentences)
- Profile Photo (square, 400x400px minimum)
- Social Links (LinkedIn, Twitter/X, GitHub)

## 6.3 Post Features

| Feature | Implementation |
|---------|---------------|
| Reading Time | "Reading Time WP" plugin or custom |
| Author Bio | Custom author box at post end |
| Related Posts | RankMath or custom query (same category) |
| Social Sharing | Social Warfare or custom buttons |
| Table of Contents | Auto-generated for long posts |
| Code Highlighting | Prism.js or Syntax Highlighter plugin |

## 6.4 Editorial Guidelines

**Post Length:**
- Short posts: 600-800 words
- Standard posts: 1,200-1,500 words
- Deep dives: 2,000-3,000 words

**Publishing Cadence:**
- Target: 2 posts per week
- Mix: 1 AI/industry insight + 1 product/company update

**SEO Requirements (per post):**
- Focus keyword
- Meta description (155 characters)
- Alt text for all images
- Internal links (2-3 per post)
- External links (1-2 authoritative sources)

# 7. Newsletter Integration

## 7.1 Signup Forms

**Locations:**
1. Home page (dedicated section)
2. Blog sidebar
3. Blog post footer
4. AI Workforce teaser page
5. Exit intent popup (optional)

**Form Fields:**
- First Name (optional but encouraged)
- Email Address (required)

**Form HTML:**
```html
<form action="[Hostinger Mailing List Endpoint]" method="POST" class="newsletter-form">
    <input type="text" name="first_name" placeholder="First name">
    <input type="email" name="email" placeholder="Email address" required>
    <button type="submit" class="btn-primary">Subscribe</button>
    <p class="privacy-note">We respect your privacy. Unsubscribe anytime.</p>
</form>
```

## 7.2 Hostinger Mailing List Setup

1. Create mailing list in Hostinger panel
2. Configure signup form action URL
3. Set up confirmation email template
4. Create welcome email sequence

**Lists to Create:**
| List | Purpose |
|------|---------|
| General Newsletter | All subscribers |
| AI Workforce Interest | Product launch notifications |

# 8. Contact Form Configuration

## 8.1 Form Fields

| Field | Type | Required | Options |
|-------|------|----------|---------|
| First Name | Text | Yes | - |
| Last Name | Text | Yes | - |
| Email | Email | Yes | - |
| Phone | Tel | Yes | - |
| Company | Text | No | - |
| Project Type | Select | No | AI Strategy, Custom Development, Integration, Other |
| Budget Range | Select | No | <$10K, $10-25K, $25-50K, $50-100K, $100K+ |
| Message | Textarea | Yes | - |
| How did you hear about us? | Select | No | Search, Social Media, Referral, Blog, Other |

## 8.2 Form Handling

**Email Notifications:**
- Send to: contact@echoforgex.com
- Subject: "New Inquiry from [Name] - [Project Type]"
- Include all form fields

**Confirmation:**
- Show success message on page
- Send confirmation email to submitter

## 8.3 Calendly Integration

**Embed Options:**
1. Inline embed on contact page
2. Popup button: "Schedule a Call"

**Meeting Types:**
- Discovery Call (30 min)
- Project Consultation (60 min)

# 9. SEO Configuration

## 9.1 Technical SEO

**RankMath Settings:**
- XML Sitemap enabled
- Schema markup (Organization, Article, Product)
- Breadcrumbs enabled
- 404 monitor
- Redirections manager

**Schema Types:**

```json
// Organization (site-wide)
{
    "@type": "Organization",
    "name": "EchoForgeX LLC",
    "url": "https://echoforgex.com",
    "logo": "https://echoforgex.com/logo.png",
    "sameAs": [
        "https://linkedin.com/company/echoforgex",
        "https://twitter.com/echoforgex",
        "https://github.com/echoforgex"
    ]
}

// Product (SignShield page)
{
    "@type": "SoftwareApplication",
    "name": "SignShield",
    "applicationCategory": "BusinessApplication",
    "operatingSystem": "Web",
    "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
    }
}
```

## 9.2 Page-Level SEO

| Page | Title | Meta Description |
|------|-------|------------------|
| Home | EchoForgeX - AI-Powered Software Studio | We build intelligent products and help businesses harness AI. Explore SignShield, our video-verified waiver platform, and upcoming AI solutions. |
| About | About EchoForgeX - Our Story & Team | Meet the team behind EchoForgeX. We're a software studio building AI-powered products and helping businesses transform with artificial intelligence. |
| Products | Our Products - EchoForgeX | Explore our product portfolio: SignShield for video-verified waivers and AI Workforce, our upcoming on-demand AI agent platform. |
| Services | AI Services - Strategy, Development & Integration | Expert AI services including strategy consulting, custom AI development, and seamless integration with your existing systems. |
| Contact | Contact EchoForgeX - Let's Build Something | Get in touch to discuss your AI project. Book a call or send us a message. We're ready to help transform your business. |

## 9.3 Performance Optimization

| Metric | Target | Method |
|--------|--------|--------|
| LCP | < 2.5s | Image optimization, caching |
| FID | < 100ms | Minimal JS, deferred loading |
| CLS | < 0.1 | Defined image dimensions |
| Mobile Score | > 90 | Responsive design, optimized assets |

**Optimization Checklist:**
- [ ] Enable WP Super Cache
- [ ] Enable Redis object caching
- [ ] Optimize images (WebP, lazy loading)
- [ ] Minify CSS/JS
- [ ] Enable Cloudflare caching
- [ ] Preload critical fonts

# 10. Security Configuration

## 10.1 WordPress Security

**Wordfence Configuration:**
- Enable firewall
- Enable brute force protection
- Block known malicious IPs
- Enable login security (2FA for admin)
- Schedule weekly malware scans

**Additional Security:**
- Hide WordPress version
- Disable XML-RPC (if not needed)
- Limit login attempts
- Change default admin username
- Use strong passwords
- Keep WordPress + plugins updated

## 10.2 Server Security

- fail2ban for SSH and WordPress login
- UFW firewall (only ports 80, 443, 22)
- Automatic security updates
- Regular backups (UpdraftPlus to cloud)

# 11. Implementation Approach

## 11.1 Recommended Phases

**Phase 1: Infrastructure (1-2 days)**
1. Install WordPress on Linode
2. Configure Nginx server block
3. Set up Cloudflare DNS
4. Install SSL certificate
5. Configure MySQL database
6. Install essential plugins

**Phase 2: Theme & Design (2-3 days)**
1. Install GeneratePress Premium
2. Configure global styles (colors, typography)
3. Create header/footer
4. Build home page
5. Build about page
6. Build contact page with form

**Phase 3: Products & Services (1-2 days)**
1. Create products landing page
2. Create SignShield product page
3. Create AI Workforce teaser page
4. Create services page

**Phase 4: Blog Setup (1 day)**
1. Configure blog layout
2. Create category pages
3. Set up author profiles
4. Create sample posts
5. Configure related posts

**Phase 5: Integrations (1 day)**
1. Set up newsletter integration
2. Configure contact form
3. Embed Calendly
4. Set up email notifications

**Phase 6: SEO & Launch (1 day)**
1. Configure RankMath
2. Set up sitemap
3. Add schema markup
4. Optimize performance
5. Submit to Google Search Console
6. Launch!

## 11.2 Dependencies

| Dependency | Notes |
|------------|-------|
| Linode server access | Same server as SignShield |
| Cloudflare account | Already in use for SignShield |
| Hostinger email | For newsletter integration |
| Calendly account | For booking integration |
| Logo files | All variants needed |
| Team photos | For about page |
| Initial blog content | 2-3 launch posts |

# 12. Acceptance Criteria

## 12.1 Infrastructure

- [ ] WordPress installed and accessible
- [ ] HTTPS working via Cloudflare
- [ ] Nginx configured correctly
- [ ] Database connection stable
- [ ] Caching enabled and working
- [ ] Backups configured

## 12.2 Design & Layout

- [ ] Brand colors implemented correctly
- [ ] Typography matches spec
- [ ] Responsive on mobile, tablet, desktop
- [ ] Dark theme consistent throughout
- [ ] Logo displays correctly in all locations
- [ ] Favicon working

## 12.3 Pages

- [ ] Home page complete with all sections
- [ ] About page with team section
- [ ] Products page with SignShield and AI Workforce
- [ ] Services page with offerings
- [ ] Blog listing functional
- [ ] Contact page with working form
- [ ] Privacy Policy page
- [ ] Terms of Service page

## 12.4 Blog

- [ ] Posts display correctly
- [ ] Categories working
- [ ] Author profiles display
- [ ] Related posts showing
- [ ] Social sharing buttons work
- [ ] Reading time displays
- [ ] SEO fields editable

## 12.5 Lead Generation

- [ ] Newsletter signup works
- [ ] Emails delivered to Hostinger list
- [ ] Contact form submissions received
- [ ] Calendly booking functional
- [ ] AI Workforce notification signup works

## 12.6 SEO & Performance

- [ ] Sitemap generated
- [ ] Schema markup present
- [ ] Meta descriptions set
- [ ] Page speed score > 90 (mobile)
- [ ] Images optimized
- [ ] Google Search Console connected

## 12.7 Security

- [ ] Wordfence active
- [ ] Login protection enabled
- [ ] Backups scheduled
- [ ] WordPress updated
- [ ] Plugins updated

---

# Appendix A: Content Checklist

## Required Content Before Launch

| Content | Owner | Status |
|---------|-------|--------|
| Home page copy | - | [ ] |
| About page - company story | - | [ ] |
| About page - team bios | - | [ ] |
| About page - team photos | - | [ ] |
| SignShield product description | - | [ ] |
| AI Workforce teaser copy | - | [ ] |
| Services descriptions | - | [ ] |
| 2-3 launch blog posts | - | [ ] |
| Privacy Policy text | - | [ ] |
| Terms of Service text | - | [ ] |

## Logo Files Needed

| File | Format | Size |
|------|--------|------|
| logo-full-horizontal.svg | SVG | - |
| logo-full-horizontal.png | PNG | 400px width |
| logo-full-stacked.svg | SVG | - |
| logo-full-stacked.png | PNG | 300px width |
| logo-icon.svg | SVG | - |
| logo-icon.png | PNG | 512px |
| favicon.ico | ICO | 32x32 |
| apple-touch-icon.png | PNG | 180x180 |

---

# Appendix B: WordPress File Structure

```
/var/www/echoforgex.com/
├── public_html/
│   ├── wp-admin/
│   ├── wp-content/
│   │   ├── themes/
│   │   │   └── generatepress_child/    # Custom child theme
│   │   ├── plugins/
│   │   ├── uploads/
│   │   └── cache/
│   ├── wp-includes/
│   ├── wp-config.php
│   └── index.php
├── logs/
│   ├── access.log
│   └── error.log
└── backups/
```

---

*End of Specification*
