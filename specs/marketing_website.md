---
title: Marketing Website
version: "1.3"
status: deployed
project: SignShield
created: 2025-01-17
updated: 2025-12-22
---

# 1. Executive Summary

Create the public-facing marketing website for SignShield, including Home, Features, Pricing, About, and Contact pages. The website will be built as a Django app with templates, serving as the primary conversion funnel for new tenant sign-ups.

# 2. Current System State

## 2.1 Existing Structure

| Component | Status |
|-----------|--------|
| Django project | Exists (`signshield/`) |
| URL routing | Exists, but no marketing routes |
| Templates | Dashboard and signing templates exist |
| Static files | Basic structure exists |

## 2.2 Current Gaps

- No public marketing pages
- No `/` homepage (currently redirects to dashboard)
- No SEO meta tags infrastructure
- No contact form functionality

# 3. Feature Requirements

## 3.1 New Django App: `marketing`

### App Structure

```
apps/marketing/
├── __init__.py
├── admin.py
├── apps.py
├── forms.py              # ContactForm
├── models.py             # ContactSubmission
├── urls.py
├── views.py
└── templates/
    └── marketing/
        ├── base_marketing.html
        ├── home.html
        ├── features.html
        ├── pricing.html
        ├── about.html
        └── contact.html
```

### URL Configuration

| URL | View | Template | Description |
|-----|------|----------|-------------|
| `/` | `HomeView` | `home.html` | Landing page |
| `/features/` | `FeaturesView` | `features.html` | Feature showcase |
| `/pricing/` | `PricingView` | `pricing.html` | Pricing tiers |
| `/about/` | `AboutView` | `about.html` | Company info |
| `/contact/` | `ContactView` | `contact.html` | Contact form |

## 3.2 Base Marketing Template

### Template: `base_marketing.html`

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{% block title %}SignShield{% endblock %} | Video-Verified Waivers</title>

    <!-- SEO Meta -->
    <meta name="description" content="{% block meta_description %}Collect legally-binding electronic signatures with video verification. Perfect for events, activities, and businesses.{% endblock %}">
    <meta name="keywords" content="electronic signature, waiver, video verification, e-signature, digital waiver">

    <!-- Open Graph -->
    <meta property="og:title" content="{% block og_title %}SignShield - Video-Verified Waivers{% endblock %}">
    <meta property="og:description" content="{% block og_description %}Collect legally-binding electronic signatures with video verification.{% endblock %}">
    <meta property="og:image" content="{% static 'images/og-image.png' %}">
    <meta property="og:url" content="{{ request.build_absolute_uri }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">

    <!-- Favicon -->
    <link rel="icon" href="{% static 'favicon.ico' %}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{% static 'css/main.css' %}">
    {% block extra_css %}{% endblock %}
</head>
<body>
    {% include 'marketing/partials/header.html' %}

    <main>
        {% block content %}{% endblock %}
    </main>

    {% include 'marketing/partials/footer.html' %}

    {% block extra_js %}{% endblock %}
</body>
</html>
```

### Header Partial

```html
<!-- templates/marketing/partials/header.html -->
<header class="site-header">
    <div class="container">
        <nav class="nav">
            <a href="/" class="logo">
                <img src="{% static 'images/logo.png' %}" alt="SignShield" height="40">
            </a>

            <ul class="nav-links">
                <li><a href="/features/">Features</a></li>
                <li><a href="/pricing/">Pricing</a></li>
                <li><a href="/about/">About</a></li>
                <li><a href="/contact/">Contact</a></li>
            </ul>

            <div class="nav-actions">
                <a href="/login/" class="btn btn-secondary">Log In</a>
                <a href="/signup/" class="btn btn-primary">Start Free</a>
            </div>

            <button class="mobile-menu-toggle" aria-label="Toggle menu">
                <span></span>
            </button>
        </nav>
    </div>
</header>
```

### Footer Partial

```html
<!-- templates/marketing/partials/footer.html -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <img src="{% static 'images/logo-white.png' %}" alt="SignShield" height="32">
                <p>Video-verified electronic waivers for modern businesses.</p>
            </div>

            <div class="footer-links">
                <h4>Product</h4>
                <ul>
                    <li><a href="/features/">Features</a></li>
                    <li><a href="/pricing/">Pricing</a></li>
                    <li><a href="/about/">About Us</a></li>
                    <li><a href="/contact/">Contact</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Legal</h4>
                <ul>
                    <li><a href="/privacy/">Privacy Policy</a></li>
                    <li><a href="/terms/">Terms of Service</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Support</h4>
                <ul>
                    <li><a href="/contact/">Help Center</a></li>
                    <li><a href="mailto:support@signshield.io">support@signshield.io</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {% now "Y" %} SignShield. All rights reserved.</p>
        </div>
    </div>
</footer>
```

## 3.3 Home Page

### Content Structure

```
[HERO SECTION]
Headline: "Waivers That Actually Hold Up in Court"
Subheadline: "Collect legally-binding signatures with video verification.
              Know exactly who signed, when, and watch them consent."
CTA Primary: "Start Free" → /signup/
CTA Secondary: "See How It Works" → #demo-video

[SOCIAL PROOF BAR]
"Trusted by 500+ businesses" | Logo cloud (placeholder for now)

[PROBLEM/SOLUTION SECTION]
Headline: "Paper Waivers Are a Liability"
Three columns:
1. "Illegible Signatures" - Can't verify who actually signed
2. "Lost Paperwork" - Documents get damaged or misplaced
3. "No Proof of Consent" - Hard to prove signer understood terms

[FEATURE HIGHLIGHTS]
Headline: "How SignShield Protects You"
Three feature cards with icons:
1. Video Verification - Signers record themselves stating name and consent
2. Legally Binding - Tamper-proof PDF with signature, timestamp, IP address
3. Easy Collection - Send links via email/SMS, track completion in real-time

[DEMO VIDEO SECTION]
Embedded video placeholder showing the signing flow

[USE CASES]
Headline: "Built for Your Business"
Cards: Adventure Sports | Fitness Studios | Events | Healthcare | Rentals

[CTA SECTION]
Headline: "Start Collecting Secure Waivers Today"
Subheadline: "Free forever for small teams. No credit card required."
CTA: "Create Free Account" → /signup/

[FOOTER]
```

### Placeholder Content

```python
# views.py
class HomeView(TemplateView):
    template_name = 'marketing/home.html'

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['stats'] = {
            'businesses': '500+',
            'waivers_collected': '50,000+',
            'uptime': '99.9%',
        }
        context['use_cases'] = [
            {'name': 'Adventure Sports', 'icon': 'mountain', 'description': 'Zip lines, rafting, climbing gyms'},
            {'name': 'Fitness Studios', 'icon': 'dumbbell', 'description': 'Gyms, yoga, CrossFit, martial arts'},
            {'name': 'Events', 'icon': 'calendar', 'description': 'Races, tournaments, festivals'},
            {'name': 'Healthcare', 'icon': 'heart', 'description': 'Clinics, therapy, wellness centers'},
            {'name': 'Rentals', 'icon': 'bike', 'description': 'Bikes, kayaks, equipment rental'},
        ]
        return context
```

## 3.4 Features Page

### Content Structure

```
[HERO]
Headline: "Everything You Need for Bulletproof Waivers"
Subheadline: "From video verification to automated reminders,
              SignShield handles the entire waiver workflow."

[FEATURE SECTIONS - Alternating left/right layout]

1. VIDEO VERIFICATION
   Headline: "See Your Signers, Not Just Their Signature"
   Description: Signers record a short video stating their name and
                acknowledging they've read and agree to the waiver.
                This creates undeniable proof of informed consent.
   Benefits:
   - Verify signer identity
   - Prove they understood the terms
   - Deter fraudulent claims

2. DIGITAL WAIVER TEMPLATES
   Headline: "Create Once, Use Forever"
   Description: Build custom waiver templates with your branding.
                Include specific clauses, acknowledgments, and
                consent checkboxes tailored to your business.
   Benefits:
   - Rich text editor
   - Custom branding (Pro plan)
   - Multiple templates per account

3. EVENT MANAGEMENT
   Headline: "Organize Participants by Event"
   Description: Create events, import participant lists, and track
                who's signed and who hasn't. Perfect for races,
                classes, and recurring activities.
   Benefits:
   - Bulk participant import (CSV)
   - Real-time status tracking
   - Automated reminder emails

4. SECURE DOCUMENT STORAGE
   Headline: "Your Records, Protected"
   Description: Signed waivers are stored securely with tamper-proof
                PDF generation. Each document includes signature image,
                video reference, timestamp, and IP address.
   Benefits:
   - 256-bit encryption
   - Audit trail
   - Easy PDF export

5. AUTOMATED WORKFLOWS
   Headline: "Set It and Forget It"
   Description: Send signing links automatically when participants
                register. Configure reminder emails for unsigned
                waivers. Get notified when signatures come in.
   Benefits:
   - Email/SMS notifications
   - Automatic reminders
   - Webhook integrations (Enterprise)

[COMPARISON TABLE]
Feature comparison across Free, Starter, Professional, Enterprise

[CTA]
"Ready to Get Started?"
"Start Free" button
```

## 3.5 Pricing Page

### Pricing Data

**Note:** This data should be loaded from `PlanLimit` model in production. The model requires
`max_team_members`, `max_kiosk_devices`, and `offline_kiosk` fields (see `planlimit_update.md`).

```python
PRICING_TIERS = [
    {
        'name': 'Free',
        'price': 0,
        'price_annual': 0,
        'description': 'For trying it out and very small one-time events',
        'limits': {
            'events': 1,
            'waivers_per_month': 10,
            'storage': '100 MB',
            'team_members': 1,
            'kiosk_devices': 0,  # Not available
        },
        'features': [
            'Basic waiver templates',
            'Email signing links',
            'PDF generation',
            'Mobile-friendly signing',
        ],
        'excluded_features': [
            'Video consent recording',
            'Kiosk mode',
            'Custom branding',
            'API access',
            'Priority support',
        ],
        'cta': 'Start Free',
        'cta_url': '/signup/',
        'highlighted': False,
        'target_customer': 'Trying it out, very small one-time events',
    },
    {
        'name': 'Starter',
        'price': 29,
        'price_annual': 290,  # $290/yr = ~$24/mo (save 17%)
        'description': 'For fitness studios, small tour operators, seasonal businesses',
        'limits': {
            'events': 10,
            'waivers_per_month': 100,
            'storage': '5 GB',
            'team_members': 3,
            'kiosk_devices': 1,
        },
        'features': [
            'Everything in Free, plus:',
            'Video consent recording',
            '1 kiosk device',
            'Custom branding (logo, colors)',
            'Email support',
        ],
        'excluded_features': [
            'Offline kiosk mode',
            'API access',
            'Priority support',
        ],
        'cta': 'Get Started',
        'cta_url': '/signup/?plan=starter',
        'highlighted': False,
        'target_customer': 'Fitness studios, small tour operators, seasonal businesses',
    },
    {
        'name': 'Professional',
        'price': 79,
        'price_annual': 790,  # $790/yr = ~$66/mo (save 17%)
        'description': 'For adventure companies, event venues, multi-location gyms',
        'limits': {
            'events': 50,
            'waivers_per_month': 500,
            'storage': '25 GB',
            'team_members': 10,
            'kiosk_devices': 3,
        },
        'features': [
            'Everything in Starter, plus:',
            '3 kiosk devices',
            'Offline kiosk mode',
            'Remove "Powered by SignShield"',
            'Bulk participant import',
            'Advanced analytics',
        ],
        'excluded_features': [
            'API access',
            'Priority support',
        ],
        'cta': 'Get Started',
        'cta_url': '/signup/?plan=professional',
        'highlighted': True,  # Most popular
        'target_customer': 'Adventure companies, event venues, multi-location gyms',
    },
    {
        'name': 'Enterprise',
        'price': 199,
        'price_annual': 1990,  # $1,990/yr = ~$166/mo (save 17%)
        'description': 'For franchises, resorts, large event companies',
        'limits': {
            'events': 'Unlimited',
            'waivers_per_month': 'Unlimited',
            'storage': '100 GB',
            'team_members': 'Unlimited',
            'kiosk_devices': 'Unlimited',
        },
        'features': [
            'Everything in Professional, plus:',
            'Unlimited kiosk devices',
            'API access',
            'Custom domain',
            'Webhook integrations',
            'Priority phone support',
            'Dedicated account manager',
        ],
        'excluded_features': [],
        'cta': 'Contact Sales',
        'cta_url': '/contact/?subject=enterprise',
        'highlighted': False,
        'target_customer': 'Franchises, resorts, large event companies',
    },
]
```

### Pricing Comparison Table

| | Free | Starter | Professional | Enterprise |
|---|---|---|---|---|
| **Price** | $0 | $29/mo | $79/mo | $199/mo |
| **Annual** | - | $290/yr (save 17%) | $790/yr (save 17%) | $1,990/yr (save 17%) |
| **Events** | 1 | 10 | 50 | Unlimited |
| **Waivers/mo** | 10 | 100 | 500 | Unlimited |
| **Storage** | 100 MB | 5 GB | 25 GB | 100 GB |
| **Team Members** | 1 | 3 | 10 | Unlimited |
| **Kiosk Devices** | - | 1 | 3 | Unlimited |
| **Video Consent** | - | ✓ | ✓ | ✓ |
| **Custom Branding** | - | ✓ | ✓ | ✓ |
| **Offline Kiosk** | - | - | ✓ | ✓ |
| **API Access** | - | - | - | ✓ |
| **Priority Support** | - | - | - | ✓ |

### Pricing Rationale

- **Video is the differentiator** — Not available on Free, drives upgrades to Starter
- **Kiosk included in paid plans** — 1 device on Starter, scales up with tier
- **Custom branding on Starter** — Essential for kiosk mode at physical locations
- **$29 entry point** — Competitive with WaiverSign, Waiver Forever
- **$79 mid-tier** — More kiosks + offline mode for multi-location businesses
- **$199 enterprise** — API + unlimited everything justifies premium

### Content Structure

```
[HERO]
Headline: "Simple, Transparent Pricing"
Subheadline: "Start free. Upgrade when you need more."
Toggle: Monthly / Annual (save 17%)

[PRICING CARDS]
4 cards in a row, Professional highlighted as "Most Popular"
Each card shows:
- Plan name
- Price (monthly/annual toggle)
- Description
- Limits (events, waivers, storage)
- Feature list
- CTA button

[FAQ SECTION]
Q: Can I change plans later?
A: Yes, upgrade or downgrade anytime. Changes take effect immediately.

Q: What happens when I hit my limits?
A: We'll notify you when you're approaching limits. You can upgrade
   or wait until the next billing cycle.

Q: Do you offer refunds?
A: Yes, we offer a 30-day money-back guarantee on all paid plans.

Q: Is there a long-term contract?
A: No, all plans are month-to-month. Cancel anytime.

Q: Do you offer discounts for nonprofits?
A: Yes! Contact us for special nonprofit pricing.

[CTA]
"Questions? We're here to help."
"Contact Sales" button
```

## 3.6 About Page

### Content Structure

```
[HERO]
Headline: "Protecting Businesses, One Waiver at a Time"
Subheadline: "We built SignShield because we saw too many businesses
              exposed to liability from paper waivers that couldn't
              hold up when challenged."

[STORY SECTION]
Headline: "Our Story"
Content: [Placeholder - 2-3 paragraphs about company origin, mission]

[VALUES SECTION]
Headline: "What We Believe"
Three value cards:
1. Security First - Your data and your customers' data is sacred
2. Simplicity - Powerful doesn't have to mean complicated
3. Transparency - Clear pricing, honest communication, no surprises

[TEAM SECTION - Optional/Placeholder]
Headline: "The Team"
Placeholder for team member photos/bios

[CTA]
"Want to learn more?"
"Contact Us" button
```

## 3.7 Contact Page

### Contact Form Model

```python
# models.py
class ContactSubmission(models.Model):
    """Stores contact form submissions"""

    SUBJECT_CHOICES = [
        ('general', 'General Inquiry'),
        ('sales', 'Sales Question'),
        ('support', 'Technical Support'),
        ('enterprise', 'Enterprise Inquiry'),
        ('partnership', 'Partnership Opportunity'),
    ]

    name = models.CharField(max_length=100)
    email = models.EmailField()
    company = models.CharField(max_length=200, blank=True)
    subject = models.CharField(max_length=20, choices=SUBJECT_CHOICES, default='general')
    message = models.TextField()

    # Metadata
    created_at = models.DateTimeField(auto_now_add=True)
    ip_address = models.GenericIPAddressField(null=True, blank=True)
    user_agent = models.TextField(blank=True)

    # Processing
    is_read = models.BooleanField(default=False)
    responded_at = models.DateTimeField(null=True, blank=True)
    notes = models.TextField(blank=True)  # Internal notes

    class Meta:
        ordering = ['-created_at']

    def __str__(self):
        return f"{self.name} - {self.get_subject_display()} - {self.created_at.date()}"
```

### Contact Form

```python
# forms.py
from django import forms
from .models import ContactSubmission

class ContactForm(forms.ModelForm):
    class Meta:
        model = ContactSubmission
        fields = ['name', 'email', 'company', 'subject', 'message']
        widgets = {
            'name': forms.TextInput(attrs={
                'placeholder': 'Your name',
                'class': 'input',
            }),
            'email': forms.EmailInput(attrs={
                'placeholder': 'you@company.com',
                'class': 'input',
            }),
            'company': forms.TextInput(attrs={
                'placeholder': 'Company name (optional)',
                'class': 'input',
            }),
            'subject': forms.Select(attrs={
                'class': 'input',
            }),
            'message': forms.Textarea(attrs={
                'placeholder': 'How can we help?',
                'class': 'input',
                'rows': 5,
            }),
        }
```

### Contact View

```python
# views.py
from django.views.generic import FormView
from django.contrib import messages
from django.core.mail import send_mail
from django.conf import settings
from .forms import ContactForm

class ContactView(FormView):
    template_name = 'marketing/contact.html'
    form_class = ContactForm
    success_url = '/contact/?submitted=true'

    def get_initial(self):
        initial = super().get_initial()
        # Pre-fill subject from query param (e.g., /contact/?subject=enterprise)
        subject = self.request.GET.get('subject')
        if subject:
            initial['subject'] = subject
        return initial

    def form_valid(self, form):
        # Save to database
        submission = form.save(commit=False)
        submission.ip_address = self.get_client_ip()
        submission.user_agent = self.request.META.get('HTTP_USER_AGENT', '')
        submission.save()

        # Send email notification
        self.send_notification_email(submission)

        messages.success(self.request, "Thanks! We'll get back to you soon.")
        return super().form_valid(form)

    def get_client_ip(self):
        x_forwarded_for = self.request.META.get('HTTP_X_FORWARDED_FOR')
        if x_forwarded_for:
            return x_forwarded_for.split(',')[0]
        return self.request.META.get('REMOTE_ADDR')

    def send_notification_email(self, submission):
        subject = f"[SignShield Contact] {submission.get_subject_display()} from {submission.name}"
        message = f"""
New contact form submission:

Name: {submission.name}
Email: {submission.email}
Company: {submission.company or 'Not provided'}
Subject: {submission.get_subject_display()}

Message:
{submission.message}

---
IP: {submission.ip_address}
Submitted: {submission.created_at}
        """
        send_mail(
            subject,
            message,
            settings.DEFAULT_FROM_EMAIL,
            [settings.CONTACT_EMAIL],  # Add to settings
            fail_silently=True,
        )
```

### Content Structure

```
[HERO]
Headline: "Get in Touch"
Subheadline: "Have a question? We'd love to hear from you."

[TWO COLUMN LAYOUT]

Left Column - Contact Form:
- Name (required)
- Email (required)
- Company (optional)
- Subject dropdown
- Message (required)
- Submit button

Right Column - Contact Info:
- Email: support@signshield.io
- Response time: "We typically respond within 24 hours"
- Office hours: "Monday-Friday, 9am-5pm EST"

[SUCCESS STATE]
When ?submitted=true:
Show success message instead of form:
"Thanks for reaching out! We'll get back to you within 24 hours."
```

# 4. Future Considerations (Out of Scope)

- Blog/content marketing section
- Help center/documentation
- Live chat integration
- Customer testimonials/case studies
- Video demos (placeholder only for now)
- Multi-language support

# 5. Implementation Approach

## 5.1 Recommended Phases

**Phase 1: Foundation**
1. Create `apps/marketing` Django app
2. Set up URL routing
3. Create base template with header/footer
4. Implement CSS from brand guidelines

**Phase 2: Static Pages**
1. Home page with placeholder content
2. Features page
3. Pricing page (static data)
4. About page

**Phase 3: Contact Form**
1. ContactSubmission model + migration
2. ContactForm implementation
3. Email notification
4. Admin interface for submissions

**Phase 4: Polish**
1. Mobile responsive adjustments
2. SEO meta tags
3. Open Graph images
4. Performance optimization

## 5.2 Spec Dependencies

This spec has dependencies on other specs that must be implemented first.

### Dependency Chain

```
┌─────────────────────┐    ┌─────────────────────┐
│  brand_guidelines   │    │  planlimit_update   │
│  (In Development)   │    │  (In Development)   │
│                     │    │                     │
│  Provides:          │    │  Provides:          │
│  • Color palette    │    │  • PlanLimit model  │
│  • Typography       │    │  • Pricing data     │
│  • Component styles │    │  • max_team_members │
│  • CSS variables    │    │  • max_kiosk_devices│
└──────────┬──────────┘    └──────────┬──────────┘
           │                          │
           └────────────┬─────────────┘
                        ▼
          ┌─────────────────────────┐
          │   marketing_website     │
          │   (This Spec)           │
          │                         │
          │   Uses:                 │
          │   • CSS from brand      │
          │   • PlanLimit for       │
          │     pricing table       │
          └─────────────────────────┘
```

### Dependency Details

| Spec | Status | Required For | Specific Dependencies |
|------|--------|--------------|----------------------|
| **brand_guidelines.md** | In Development | All pages | CSS variables, color palette, typography, component styles |
| **planlimit_update.md** | In Development | Pricing page | `PlanLimit.get_plan()`, pricing data, all limit fields |

### What This Spec Provides To Others

| Downstream Spec | What We Provide |
|-----------------|-----------------|
| **tenant_self_registration** | Sign-up link placement, base templates, header/footer |

### Implementation Order

```
1. brand_guidelines.md    ─┐
                           ├──► 3. marketing_website.md
2. planlimit_update.md    ─┘
```

**Note:** The pricing page uses `PlanLimit` data. Ensure planlimit_update.md is complete so the pricing table displays accurate tier information.

## 5.3 Infrastructure Dependencies

| Dependency | Notes |
|------------|-------|
| Static file serving | Ensure whitenoise or similar configured |
| Email settings | For contact form notifications |

| Plan | max_events | max_waivers_per_month | max_storage_mb |
|------|------------|----------------------|----------------|
| free | 1 | 10 | 100 |
| starter | 10 | 100 | 5120 (5 GB) |
| professional | 50 | 500 | 25600 (25 GB) |
| enterprise | 0 | 0 | 102400 (100 GB) |

# 6. Acceptance Criteria

## 6.1 Infrastructure

- [ ] `apps/marketing` app created and registered
- [ ] URL routing configured for all pages
- [ ] Base template with header/footer working
- [ ] Static assets loading correctly

## 6.2 Pages

- [ ] Home page renders with all sections
- [ ] Features page renders with feature details
- [ ] Pricing page shows all 4 tiers correctly
- [ ] About page renders
- [ ] Contact page form submits successfully

## 6.3 Contact Form

- [ ] Form validation works (required fields)
- [ ] Submission saved to database
- [ ] Email notification sent
- [ ] Success message displayed
- [ ] Subject pre-fill from query param works

## 6.4 Responsive Design

- [ ] All pages work on mobile (320px+)
- [ ] Navigation collapses to mobile menu
- [ ] Pricing cards stack on mobile

## 6.5 SEO

- [ ] Unique title tags per page
- [ ] Meta descriptions set
- [ ] Open Graph tags present
- [ ] Semantic HTML structure

---

# Changelog

## v1.2 - 2025-01-17
- Added Kiosk Devices to pricing tiers (Starter: 1, Pro: 3, Enterprise: Unlimited)
- Added Offline Kiosk feature (Pro+ only)
- Moved Custom Branding to Starter tier (required for kiosk branding)
- Updated PRICING_TIERS data structure with kiosk fields
- Updated pricing comparison table
- Updated PlanLimit dependency note

## v1.1 - 2025-01-17
- Updated pricing tiers with finalized values
- Added Team Members limit to all plans
- Added pricing comparison table
- Added pricing rationale
- Added PlanLimit model update requirements
- Corrected storage limits: Starter 5GB, Pro 25GB, Enterprise 100GB
- Corrected event limits: Starter 10, Pro 50

## v1.0 - 2025-01-17
- Initial specification

---
*End of Specification*
