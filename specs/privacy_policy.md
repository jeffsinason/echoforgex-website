---
title: Privacy Policy Page
version: "1.3"
status: deployed
project: SignShield
created: 2025-12-23
updated: 2025-12-25
---

# 1. Executive Summary

Create a Privacy Policy page for SignShield that explains how we collect, use, store, and protect personal data for both tenant businesses and individual signers. Must comply with applicable privacy regulations (GDPR, CCPA) and be accessible publicly.

# 2. Current System State

## 2.1 Data Collection Points

| Data Type | Collected From | Purpose |
|-----------|---------------|---------|
| Business info | Tenant signup | Account creation |
| User credentials | Tenant users | Authentication |
| Signer PII | Waiver signing | Waiver records |
| Video recordings | Waiver signing | Verification |
| Signature images | Waiver signing | Legal record |
| Payment info | Billing | Subscription |
| Usage analytics | All users | Service improvement |

## 2.2 Current Gaps

- No Privacy Policy page
- No documented data handling practices
- No GDPR/CCPA compliance documentation
- No cookie consent mechanism

# 3. Feature Requirements

## 3.1 Page Location & URLs

| URL | Purpose |
|-----|---------|
| `signshield.io/privacy/` | Main Privacy Policy page |
| `signshield.io/privacy-policy/` | Redirect to /privacy/ |

## 3.2 Page Structure

### Header Section

```
┌─────────────────────────────────────────────────────────────┐
│  SignShield Logo                                             │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  Privacy Policy                                              │
│                                                              │
│  Effective Date: [DATE]                                      │
│  Last Updated: [DATE]                                        │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

### Content Sections

**TODO: Legal review required for all content below**

1. **Introduction**
   - Who we are (SignShield / EchoForgeX LLC)
   - What this policy covers
   - Commitment to privacy

2. **Information We Collect**

   *From Tenant Businesses:*
   - Account information (name, email, company)
   - Billing information (handled by Stripe)
   - Usage data

   *From Signers:*
   - Name, email, phone (as collected by waiver)
   - Signature image
   - Video recording (consent statement)
   - IP address, browser info

   *Automatically Collected:*
   - Cookies and tracking
   - Device information
   - Log data

3. **How We Use Your Information**
   - Provide the service
   - Process payments
   - Send notifications
   - Improve the service
   - Legal compliance

4. **Data Sharing & Disclosure**
   - Tenant access to signer data
   - Service providers (see Sub-processors below)
   - Legal requirements
   - Business transfers
   - **We do not sell personal data**

   *Sub-processors:*

   | Provider | Service | Location | Data Processed |
   |----------|---------|----------|----------------|
   | Amazon Web Services (AWS) | Cloud hosting, storage | USA | All service data |
   | Stripe | Payment processing | USA | Tenant billing info |
   | Hostinger | Email delivery | USA/EU | Email addresses, names |
   | Cloudflare | CDN, security, DNS | USA | IP addresses, requests |
   | Linode (Akamai) | Server hosting | USA | All service data |

   *Sub-processor changes:* We will update this list when adding new sub-processors. Material changes affecting data processing will be communicated to account holders via email with 30 days notice.

5. **Data Retention**
   - Active waiver retention: [X years based on tenant setting]
   - Archived waivers: Per retention policy
   - Account data: Duration of account + [X months]
   - Deleted data: Purged within [X days]

6. **Data Security**
   - Encryption in transit (TLS)
   - Encryption at rest
   - Access controls
   - Regular security audits
   - Incident response

7. **Your Rights**

   *All Users:*
   - Access your data
   - Correct inaccurate data
   - Delete your data (subject to legal retention requirements)
   - Data portability (export in common format)
   - Withdraw consent for optional processing

   *EU Users:* See Section 10 "GDPR Compliance" for detailed rights under GDPR

   *CCPA (California Users):*
   - Right to know what data we collect
   - Right to delete your data
   - Right to opt-out of sale (N/A - we do not sell personal data)
   - Right to non-discrimination for exercising rights
   - Authorized agent can submit requests on your behalf

8. **Cookies & Tracking**
   - Essential cookies (session, CSRF)
   - Analytics cookies (if any)
   - How to manage cookies
   - Do Not Track signals

9. **International Data Transfers**
   - Data stored in US (AWS us-east-1 region)
   - EU-US Data Privacy Framework compliance
   - Standard Contractual Clauses (SCCs) with sub-processors
   - Technical safeguards: encryption in transit and at rest
   - Sub-processors: AWS, Stripe, Hostinger (email) - all with adequate protections

10. **GDPR Compliance (EU Users)**

    *Legal Basis for Processing:*
    - Contract performance (providing the service)
    - Legitimate interests (security, fraud prevention)
    - Consent (marketing communications)
    - Legal obligations (tax, compliance records)

    *Your GDPR Rights:*
    - Right of access (Article 15)
    - Right to rectification (Article 16)
    - Right to erasure / "right to be forgotten" (Article 17)
    - Right to restrict processing (Article 18)
    - Right to data portability (Article 20)
    - Right to object (Article 21)
    - Right to withdraw consent (Article 7)
    - Right to lodge complaint with supervisory authority

    *Data Controller vs Processor:*
    - SignShield is the **Data Controller** for: tenant account data, billing data
    - SignShield is the **Data Processor** for: signer waiver data (tenant is controller)
    - Tenants are **Data Controllers** for their signers' data

    *Data Processing Agreements:*
    - Standard DPA terms incorporated into Terms of Service (all customers)
    - Standalone DPA available upon request for Enterprise customers
    - Covers sub-processor list, security measures, breach notification

    *Data Retention Limits:*
    - We retain data only as long as necessary
    - Waiver retention per tenant settings (3-10 years for legal compliance)
    - Account data deleted within 90 days of account closure

    *Automated Decision Making:*
    - We do not use automated decision-making or profiling that produces legal effects

11. **Data Breach Notification**
    - We maintain incident response procedures
    - GDPR: Supervisory authority notified within 72 hours of becoming aware
    - GDPR: Affected individuals notified without undue delay if high risk
    - Tenants notified promptly of any breach affecting their data
    - Breach notification includes: nature of breach, data affected, remedial actions

12. **Children's Privacy**
    - Service not intended for under 18
    - Signers must be 18+ or have guardian
    - No knowing collection from children

13. **Third-Party Links**
    - We're not responsible for external sites
    - Review their privacy policies

14. **Changes to This Policy**
    - Notification of material changes
    - Effective date updates
    - Material changes communicated via email to account holders

15. **Contact Us**
    - Privacy inquiries email: privacy@signshield.io
    - General inquiries: support@signshield.io
    - Data protection inquiries: Include "GDPR Request" or "Privacy Request" in subject
    - Response time: Within 30 days (GDPR requirement)
    - Mailing address: [To be added]

## 3.3 Link Placements

Privacy Policy link must appear in:

| Location | Format |
|----------|--------|
| Marketing website footer | Text link |
| Signup page | Checkbox agreement (with ToS) |
| Dashboard footer | Text link |
| Signing page footer | Text link |
| Email footers | Text link |
| Cookie banner | Text link |

## 3.4 Unified Legal Acceptance

**Note:** Acceptance of the Privacy Policy is tracked together with Terms of Service acceptance using a single checkbox during tenant registration. See `terms_of_service.md` Section 3.5 for the data model.

The `TenantUser` model stores:
- `legal_accepted_at` - When user accepted both documents
- `privacy_version_accepted` - Version of Privacy Policy accepted (e.g., "2025.1")
- `tos_version_accepted` - Version of ToS accepted (e.g., "2025.1")
- `legal_acceptance_ip` - IP address at time of acceptance

This approach:
- Follows industry standard (single checkbox for both documents)
- Provides audit trail for both documents
- Allows tracking version acceptance separately
- Records at registration time via `tenant_self_registration.md` flow

## 3.5 Cookie Consent Banner

**TODO: Determine if cookie consent banner is required based on tracking implementation**

```
┌─────────────────────────────────────────────────────────────┐
│  🍪 We use cookies to improve your experience.              │
│                                                              │
│  [Accept All]  [Essential Only]  [Manage Preferences]       │
│                                                              │
│  Learn more in our Privacy Policy                           │
└─────────────────────────────────────────────────────────────┘
```

## 3.6 Data Subject Request Handling

### Request Types

| Request | Response Time | Process |
|---------|--------------|---------|
| Access | 30 days | Export user data |
| Correction | 30 days | Update records |
| Deletion | 30 days | Delete or anonymize |
| Portability | 30 days | Export in common format |

### Request Workflow

1. User submits request via email or dashboard
2. Verify identity
3. Process request
4. Confirm completion

**TODO: Decide if self-service data export/deletion should be in dashboard**

## 3.7 Signer Privacy Notice

On signing pages, display brief privacy notice:

```
┌─────────────────────────────────────────────────────────────┐
│  Your Privacy                                                │
│                                                              │
│  Your information is collected by [Tenant Name] using        │
│  SignShield. Your data is stored securely and retained       │
│  per their policies. View our Privacy Policy for details.   │
└─────────────────────────────────────────────────────────────┘
```

# 4. Future Considerations (Out of Scope)

- Self-service data export in dashboard
- Automated GDPR/CCPA request handling
- Consent management platform integration
- Region-specific privacy policy versions
- Privacy impact assessments

# 5. Implementation Approach

## 5.1 Django Implementation

### URL Configuration

```python
# apps/marketing/urls.py (or signshield/urls.py)

from django.urls import path
from django.views.generic import RedirectView
from . import views

urlpatterns = [
    # Privacy Policy
    path('privacy/', views.PrivacyPolicyView.as_view(), name='privacy'),
    path('privacy-policy/', RedirectView.as_view(pattern_name='privacy', permanent=True)),

    # Terms of Service (add here for consistency)
    path('terms/', views.TermsOfServiceView.as_view(), name='terms'),
    path('terms-of-service/', RedirectView.as_view(pattern_name='terms', permanent=True)),
    path('tos/', RedirectView.as_view(pattern_name='terms', permanent=True)),
]
```

### Views

```python
# apps/marketing/views.py

from django.views.generic import TemplateView


class PrivacyPolicyView(TemplateView):
    """Privacy Policy page - public, no auth required."""
    template_name = 'marketing/privacy.html'

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['page_title'] = 'Privacy Policy'
        context['effective_date'] = '2025-01-01'  # Update when published
        context['last_updated'] = '2025-01-01'
        return context


class TermsOfServiceView(TemplateView):
    """Terms of Service page - public, no auth required."""
    template_name = 'marketing/terms.html'

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['page_title'] = 'Terms of Service'
        context['effective_date'] = '2025-01-01'  # Update when published
        context['last_updated'] = '2025-01-01'
        return context
```

### Template Structure

```
templates/
├── marketing/
│   ├── base_legal.html      # Base template for legal pages
│   ├── privacy.html         # Privacy Policy content
│   └── terms.html           # Terms of Service content
```

### Base Legal Template

```html
<!-- templates/marketing/base_legal.html -->
{% extends "base.html" %}

{% block content %}
<div class="legal-page">
    <div class="legal-header">
        <h1>{{ page_title }}</h1>
        <p class="legal-dates">
            <strong>Effective Date:</strong> {{ effective_date }}<br>
            <strong>Last Updated:</strong> {{ last_updated }}
        </p>
    </div>

    <nav class="legal-toc">
        <h2>Table of Contents</h2>
        {% block toc %}{% endblock %}
    </nav>

    <div class="legal-content">
        {% block legal_content %}{% endblock %}
    </div>
</div>
{% endblock %}
```

### Privacy Policy Template

```html
<!-- templates/marketing/privacy.html -->
{% extends "marketing/base_legal.html" %}

{% block toc %}
<ol>
    <li><a href="#introduction">Introduction</a></li>
    <li><a href="#information-we-collect">Information We Collect</a></li>
    <li><a href="#how-we-use">How We Use Your Information</a></li>
    <li><a href="#data-sharing">Data Sharing & Disclosure</a></li>
    <li><a href="#data-retention">Data Retention</a></li>
    <li><a href="#data-security">Data Security</a></li>
    <li><a href="#your-rights">Your Rights</a></li>
    <li><a href="#cookies">Cookies & Tracking</a></li>
    <li><a href="#international-transfers">International Data Transfers</a></li>
    <li><a href="#gdpr">GDPR Compliance</a></li>
    <li><a href="#breach-notification">Data Breach Notification</a></li>
    <li><a href="#children">Children's Privacy</a></li>
    <li><a href="#third-party">Third-Party Links</a></li>
    <li><a href="#changes">Changes to This Policy</a></li>
    <li><a href="#contact">Contact Us</a></li>
</ol>
{% endblock %}

{% block legal_content %}
<section id="introduction">
    <h2>1. Introduction</h2>
    <p>SignShield ("we", "our", or "us") is operated by EchoForgeX LLC.
    This Privacy Policy explains how we collect, use, disclose, and safeguard
    your information when you use our video-verified digital waiver platform.</p>
</section>

<section id="information-we-collect">
    <h2>2. Information We Collect</h2>

    <h3>From Tenant Businesses</h3>
    <ul>
        <li>Account information (name, email, company name)</li>
        <li>Billing information (processed by Stripe)</li>
        <li>Usage data</li>
    </ul>

    <h3>From Signers</h3>
    <ul>
        <li>Name, email, phone (as required by waiver)</li>
        <li>Signature image</li>
        <li>Video recording of consent statement</li>
        <li>IP address and browser information</li>
    </ul>

    <h3>Automatically Collected</h3>
    <ul>
        <li>Cookies (session, CSRF protection)</li>
        <li>Device information</li>
        <li>Log data</li>
    </ul>
</section>

<!-- Continue with remaining sections... -->
<!-- Full content to be drafted with legal counsel -->

<section id="data-sharing">
    <h2>4. Data Sharing & Disclosure</h2>
    <p>We do not sell your personal data. We share data only with:</p>
    <ul>
        <li>Tenant businesses (for signer data they collect)</li>
        <li>Service providers (sub-processors listed below)</li>
        <li>Legal authorities when required by law</li>
    </ul>

    <h3>Sub-processors</h3>
    <table class="legal-table">
        <thead>
            <tr>
                <th>Provider</th>
                <th>Service</th>
                <th>Location</th>
                <th>Data Processed</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Amazon Web Services (AWS)</td>
                <td>Cloud hosting, storage</td>
                <td>USA</td>
                <td>All service data</td>
            </tr>
            <tr>
                <td>Stripe</td>
                <td>Payment processing</td>
                <td>USA</td>
                <td>Tenant billing info</td>
            </tr>
            <tr>
                <td>Hostinger</td>
                <td>Email delivery</td>
                <td>USA/EU</td>
                <td>Email addresses, names</td>
            </tr>
            <tr>
                <td>Cloudflare</td>
                <td>CDN, security</td>
                <td>USA</td>
                <td>IP addresses, requests</td>
            </tr>
            <tr>
                <td>Linode (Akamai)</td>
                <td>Server hosting</td>
                <td>USA</td>
                <td>All service data</td>
            </tr>
        </tbody>
    </table>
    <p><em>Last updated: {{ last_updated }}</em></p>
</section>

<section id="gdpr">
    <h2>10. GDPR Compliance (EU Users)</h2>

    <h3>Legal Basis for Processing</h3>
    <ul>
        <li><strong>Contract performance:</strong> Providing the service you signed up for</li>
        <li><strong>Legitimate interests:</strong> Security, fraud prevention</li>
        <li><strong>Consent:</strong> Marketing communications</li>
        <li><strong>Legal obligations:</strong> Tax records, compliance</li>
    </ul>

    <h3>Your GDPR Rights</h3>
    <ul>
        <li>Right of access (Article 15)</li>
        <li>Right to rectification (Article 16)</li>
        <li>Right to erasure (Article 17)</li>
        <li>Right to restrict processing (Article 18)</li>
        <li>Right to data portability (Article 20)</li>
        <li>Right to object (Article 21)</li>
        <li>Right to withdraw consent (Article 7)</li>
        <li>Right to lodge complaint with supervisory authority</li>
    </ul>

    <h3>Data Controller vs Processor</h3>
    <ul>
        <li>SignShield is the <strong>Data Controller</strong> for tenant account and billing data</li>
        <li>SignShield is the <strong>Data Processor</strong> for signer waiver data</li>
        <li>Tenants are <strong>Data Controllers</strong> for their signers' data</li>
    </ul>
</section>

<section id="contact">
    <h2>15. Contact Us</h2>
    <p>For privacy-related inquiries:</p>
    <ul>
        <li><strong>Email:</strong> privacy@signshield.io</li>
        <li><strong>Subject line:</strong> Include "Privacy Request" or "GDPR Request"</li>
        <li><strong>Response time:</strong> Within 30 days</li>
    </ul>
    <p>For general support: support@signshield.io</p>
</section>
{% endblock %}
```

### CSS Styles for Legal Pages

```css
/* static/css/legal.css */

.legal-page {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 20px;
}

.legal-header h1 {
    margin-bottom: 10px;
}

.legal-dates {
    color: #666;
    font-size: 14px;
    margin-bottom: 30px;
}

.legal-toc {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 40px;
}

.legal-toc h2 {
    font-size: 18px;
    margin-bottom: 15px;
}

.legal-toc ol {
    margin: 0;
    padding-left: 20px;
}

.legal-toc li {
    margin-bottom: 8px;
}

.legal-content section {
    margin-bottom: 40px;
}

.legal-content h2 {
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
    margin-top: 40px;
}

.legal-content h3 {
    margin-top: 25px;
}

.legal-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}

.legal-table th,
.legal-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.legal-table th {
    background: #f8f9fa;
}

@media print {
    .legal-toc {
        page-break-after: always;
    }
}
```

### Footer Link Integration

Update base template footers to include privacy/terms links:

```html
<!-- templates/base.html or templates/includes/footer.html -->
<footer>
    <div class="footer-links">
        <a href="{% url 'privacy' %}">Privacy Policy</a>
        <a href="{% url 'terms' %}">Terms of Service</a>
    </div>
</footer>
```

### Signer Privacy Notice (Signing Pages)

```html
<!-- templates/signing/sign.html - Add to existing template -->
<div class="signer-privacy-notice">
    <p>
        <strong>Your Privacy:</strong> Your information is collected by
        <strong>{{ tenant.name }}</strong> using SignShield. Your data is
        stored securely and retained per their policies.
        <a href="{% url 'privacy' %}" target="_blank">View our Privacy Policy</a>
    </p>
</div>
```

## 5.2 Recommended Phases

**Phase 1: Page Infrastructure (1 hour)**
1. Create `apps/marketing/` app if not exists
2. Add URL routes with redirects
3. Create base legal template
4. Add basic Privacy Policy template with placeholder content

**Phase 2: Footer Integration (30 min)**
1. Add footer links to base template
2. Add links to dashboard base template
3. Add links to signing page template
4. Add links to email templates

**Phase 3: Styling (30 min)**
1. Create legal.css with print-friendly styles
2. Test responsive layout
3. Verify table displays correctly

**Phase 4: Content (requires legal input)**
1. Complete all content sections
2. Legal review
3. Update effective_date in view

## 5.3 Dependencies

| Dependency | Notes |
|------------|-------|
| terms_of_service.md | Should be developed in parallel |
| marketing_website.md | Footer integration |
| tenant_self_registration.md | Signup checkbox |
| waiver_archival.md | Data retention details |
| **Legal counsel** | Content must be reviewed by attorney |

# 6. Acceptance Criteria

## 6.1 Page Display

- [ ] Privacy Policy page accessible at /privacy/
- [ ] Redirect works from /privacy-policy/
- [ ] Page displays effective date and last updated date
- [ ] Table of contents with working anchor links
- [ ] Mobile responsive layout
- [ ] Print-friendly styling

## 6.2 Link Placement

- [ ] Link in marketing website footer
- [ ] Link in dashboard footer
- [ ] Link in signing page footer
- [ ] Link in email footers

## 6.3 Signing Page Notice

- [ ] Brief privacy notice displayed on signing pages
- [ ] Tenant name dynamically inserted
- [ ] Link to full privacy policy

## 6.4 Cookie Consent (if implemented)

- [ ] Banner displays on first visit
- [ ] User can accept all cookies
- [ ] User can reject non-essential cookies
- [ ] Preference is remembered
- [ ] Analytics respect cookie preferences

## 6.5 GDPR Compliance

- [ ] Legal basis for processing clearly stated
- [ ] Data Controller vs Processor roles documented
- [ ] All GDPR rights listed with article references
- [ ] Data breach notification procedures documented
- [ ] International data transfer safeguards explained
- [ ] Sub-processor list available
- [ ] Data Processing Agreement (DPA) template available for tenants
- [ ] 30-day response time for data subject requests documented
- [ ] Right to lodge complaint with supervisory authority mentioned
- [ ] Contact method for privacy requests clearly stated

## 6.6 CCPA Compliance

- [ ] "Do Not Sell My Personal Information" statement (even if N/A)
- [ ] Right to know, delete, and opt-out explained
- [ ] Non-discrimination policy stated
- [ ] Authorized agent process mentioned

---

# TODO Items for Content Development

- [ ] Consult with legal counsel for content drafting
- [ ] Determine exact data retention periods
- [ ] Document all third-party services and their privacy practices
- [ ] Determine if DPO appointment is required
- [ ] Review GDPR requirements for EU users
- [ ] Review CCPA requirements for California users
- [ ] Decide on cookie consent implementation
- [ ] Create data processing agreements with vendors

---

# Changelog

## v1.3 - 2025-12-25
- Added Section 3.4: Unified Legal Acceptance
  - References terms_of_service.md for TenantUser model fields
  - Documents single-checkbox approach for both ToS and Privacy Policy
  - Explains version tracking for both documents
- Renumbered sections 3.5-3.7

## v1.2 - 2025-12-24
- Added Sub-processor list table to Section 4 (Data Sharing):
  - AWS, Stripe, Hostinger, Cloudflare, Linode
  - Data processed by each
  - 30-day notice for sub-processor changes
- Updated DPA availability (standard in ToS, standalone for Enterprise)

## v1.1 - 2025-12-24
- Added comprehensive GDPR compliance section (Section 10):
  - Legal basis for processing
  - Full list of GDPR rights with Article references
  - Data Controller vs Processor clarification
  - Data Processing Agreement availability
  - Automated decision-making statement
- Added Data Breach Notification section (Section 11)
- Enhanced International Data Transfers section:
  - EU-US Data Privacy Framework
  - Standard Contractual Clauses
  - Sub-processor list
- Enhanced CCPA section with authorized agent provision
- Added GDPR and CCPA acceptance criteria
- Updated contact section with response time requirements

## v1.0 - 2025-12-23
- Initial draft specification

---
*End of Specification*
