---
title: Terms of Service Page
version: "1.3"
status: deployed
project: SignShield
created: 2025-12-23
updated: 2025-12-25
---

# 1. Executive Summary

Create a Terms of Service (ToS) page for SignShield that defines the legal agreement between SignShield and its users (both tenant businesses and individual signers). The page must be accessible publicly and linked from key locations throughout the application.

# 2. Current System State

## 2.1 Existing Pages

| Page | Status |
|------|--------|
| Marketing website | In development |
| Signing pages | Exist (public) |
| Dashboard | Exists (authenticated) |
| Terms of Service | **Does not exist** |

## 2.2 Current Gaps

- No Terms of Service page
- No legal framework for platform usage
- No defined liability limitations
- No user responsibilities documented

# 3. Feature Requirements

## 3.1 Page Location & URLs

| URL | Purpose |
|-----|---------|
| `signshield.io/terms/` | Main ToS page (public) |
| `signshield.io/terms-of-service/` | Redirect to /terms/ |
| `signshield.io/tos/` | Redirect to /terms/ |

## 3.2 Page Structure

### Header Section

```
┌─────────────────────────────────────────────────────────────┐
│  SignShield Logo                                             │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  Terms of Service                                            │
│                                                              │
│  Effective Date: [DATE]                                      │
│  Last Updated: [DATE]                                        │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

### Table of Contents

Auto-generated from section headings with anchor links.

### Content Sections

**TODO: Legal review required for all content below**

1. **Acceptance of Terms**
   - Agreement by using the service
   - Age requirements (18+)
   - Authority to bind organization (for business accounts)

2. **Description of Service**
   - What SignShield provides
   - Video-verified waiver collection
   - Multi-tenant SaaS platform

3. **Account Registration**
   - Accurate information required
   - Account security responsibilities
   - One account per business

4. **Subscription Plans & Billing**
   - Plan tiers and features
   - Billing cycle and payment terms
   - Refund policy
   - Plan changes and downgrades

5. **Acceptable Use Policy**
   - Permitted uses
   - Prohibited activities
   - Content restrictions

6. **Waiver Content & Liability**
   - Tenant responsibility for waiver content
   - SignShield not liable for waiver enforceability
   - Legal review recommendation

7. **Data & Privacy**
   - Reference to Privacy Policy
   - Data retention
   - Signer data handling

8. **Data Processing Terms (DPA)**

   *This section serves as the Data Processing Agreement for GDPR compliance:*

   - **Roles:** SignShield acts as Data Processor; Customer acts as Data Controller for signer data
   - **Processing scope:** SignShield processes personal data only as necessary to provide the service
   - **Sub-processors:** Customer authorizes use of sub-processors listed in Privacy Policy
   - **Security measures:** Encryption in transit (TLS) and at rest, access controls, regular audits
   - **Data breach notification:** SignShield will notify Customer within 72 hours of confirmed breach
   - **Data subject requests:** SignShield will assist Customer in responding to data subject requests
   - **Data deletion:** Upon termination, Customer data deleted within 90 days (unless legal retention required)
   - **Audit rights:** Enterprise customers may request compliance documentation
   - **International transfers:** Governed by Standard Contractual Clauses where applicable
   - **Instructions:** SignShield processes data only per Customer's documented instructions (this Agreement)

   *Enterprise customers requiring a standalone DPA may contact legal@signshield.io*

9. **Intellectual Property**
   - SignShield ownership
   - Tenant content ownership
   - License grants

10. **Limitation of Liability**
    - Service provided "as is"
    - Liability caps
    - Exclusions

11. **Indemnification**
    - Tenant indemnifies SignShield
    - Scope of indemnification

12. **Termination**
    - Termination by user
    - Termination by SignShield
    - Effect of termination
    - Data export period

13. **Dispute Resolution**
    - Governing law
    - Arbitration clause (if applicable)
    - Jurisdiction

14. **Changes to Terms**
    - Notification of changes
    - Continued use = acceptance

15. **Contact Information**
    - Legal inquiries: legal@signshield.io
    - General support: support@signshield.io
    - Mailing address: [To be added]

## 3.3 Link Placements

ToS link must appear in:

| Location | Format |
|----------|--------|
| Marketing website footer | Text link |
| Signup page | Checkbox agreement |
| Dashboard footer | Text link |
| Signing page footer | Text link |
| Email footers | Text link |

## 3.4 Signup Agreement

During tenant registration:

```
┌─────────────────────────────────────────────────────────────┐
│  [ ] I agree to the Terms of Service and Privacy Policy    │
│                                                              │
│      By checking this box, you confirm that you have read   │
│      and agree to our Terms of Service and Privacy Policy.  │
└─────────────────────────────────────────────────────────────┘
```

- Checkbox must be checked to proceed
- Links open in new tab
- Agreement timestamp stored in database

## 3.5 Data Model Changes

**Unified Legal Acceptance**: A single checkbox during registration covers both Terms of Service and Privacy Policy. This is the standard approach used by most SaaS platforms.

```python
# apps/core/models.py - Add to TenantUser

class TenantUser(models.Model):
    # ... existing fields ...

    # Legal acceptance tracking (single checkbox covers both documents)
    legal_accepted_at = models.DateTimeField(null=True, blank=True)
    tos_version_accepted = models.CharField(max_length=20, blank=True)
    privacy_version_accepted = models.CharField(max_length=20, blank=True)
    legal_acceptance_ip = models.GenericIPAddressField(null=True, blank=True)

    def record_legal_acceptance(self, ip_address=None, tos_version='2025.1', privacy_version='2025.1'):
        """Record that user accepted ToS and Privacy Policy"""
        from django.utils import timezone
        self.legal_accepted_at = timezone.now()
        self.tos_version_accepted = tos_version
        self.privacy_version_accepted = privacy_version
        self.legal_acceptance_ip = ip_address
        self.save(update_fields=[
            'legal_accepted_at',
            'tos_version_accepted',
            'privacy_version_accepted',
            'legal_acceptance_ip'
        ])
```

## 3.6 Version Tracking

| Field | Type | Description |
|-------|------|-------------|
| `legal_accepted_at` | DateTimeField | When user accepted ToS + Privacy Policy |
| `tos_version_accepted` | CharField | ToS version string (e.g., "2025.1") |
| `privacy_version_accepted` | CharField | Privacy Policy version (e.g., "2025.1") |
| `legal_acceptance_ip` | GenericIPAddressField | IP at time of acceptance |

## 3.7 When Acceptance is Recorded

Legal acceptance is recorded during **tenant self-registration** (see `tenant_self_registration.md`):

1. User fills out registration form with checkbox: "I agree to the Terms of Service and Privacy Policy"
2. User verifies email
3. On verification, `TenantUser` is created with `role='owner'`
4. `record_legal_acceptance()` is called with the registration IP address

```python
# In VerifyEmailView.create_account() - tenant_self_registration.md

# Create TenantUser as owner
tenant_user = TenantUser.objects.create(
    user=user,
    tenant=tenant,
    role='owner',
    is_active=True,
    accepted_at=timezone.now(),
)

# Record legal acceptance from registration
tenant_user.record_legal_acceptance(
    ip_address=verification.ip_address,
    tos_version='2025.1',
    privacy_version='2025.1',
)
```

# 4. Future Considerations (Out of Scope)

- ToS change notification system (email users when ToS updates)
- Re-acceptance requirement for major changes
- ToS versioning with diff view
- Localized ToS for different regions

# 5. Implementation Approach

## 5.1 Recommended Phases

**Phase 1: Page Infrastructure**
1. Create ToS view and template
2. Add URL routes with redirects
3. Add footer links throughout application

**Phase 2: Signup Integration**
1. Add agreement checkbox to signup
2. Store acceptance data in database
3. Require acceptance to complete registration

**Phase 3: Content** (requires legal input)
1. Draft ToS content
2. Legal review
3. Publish final version

## 5.2 Dependencies

| Dependency | Notes |
|------------|-------|
| privacy_policy.md | Should be developed in parallel |
| marketing_website.md | Footer integration |
| tenant_self_registration.md | Signup checkbox |
| **Legal counsel** | Content must be reviewed by attorney |

# 6. Acceptance Criteria

## 6.1 Page Display

- [ ] ToS page accessible at /terms/
- [ ] Redirects work from /terms-of-service/ and /tos/
- [ ] Page displays effective date and last updated date
- [ ] Table of contents with working anchor links
- [ ] Mobile responsive layout
- [ ] Print-friendly styling

## 6.2 Link Placement

- [ ] Link in marketing website footer
- [ ] Link in dashboard footer
- [ ] Link in signing page footer
- [ ] Link in email footers

## 6.3 Signup Integration (Unified Legal Acceptance)

- [ ] Single agreement checkbox on signup page (covers ToS + Privacy Policy)
- [ ] Cannot submit without checking box
- [ ] Links open in new tab
- [ ] `legal_accepted_at` timestamp stored on TenantUser
- [ ] `tos_version_accepted` stored on TenantUser
- [ ] `privacy_version_accepted` stored on TenantUser
- [ ] `legal_acceptance_ip` stored on TenantUser
- [ ] `record_legal_acceptance()` method works correctly

## 6.4 Data Processing Terms (DPA)

- [ ] DPA section included in Terms of Service
- [ ] Roles clearly defined (Controller vs Processor)
- [ ] Sub-processor authorization references Privacy Policy
- [ ] Security measures documented
- [ ] 72-hour breach notification commitment
- [ ] Data deletion timeline stated (90 days)
- [ ] Enterprise DPA contact email provided (legal@signshield.io)

# 7. Django Implementation

## 7.1 Shared Infrastructure

**Note:** URL configuration, views, base template (`base_legal.html`), and CSS styles are defined in `privacy_policy.md`. Both pages share the same infrastructure.

## 7.2 Terms of Service Template

```html
<!-- templates/marketing/terms.html -->
{% extends "marketing/base_legal.html" %}

{% block legal_content %}
<nav class="legal-toc">
    <h2>Table of Contents</h2>
    <ol>
        <li><a href="#acceptance">Acceptance of Terms</a></li>
        <li><a href="#description">Description of Service</a></li>
        <li><a href="#registration">Account Registration</a></li>
        <li><a href="#billing">Subscription Plans & Billing</a></li>
        <li><a href="#acceptable-use">Acceptable Use Policy</a></li>
        <li><a href="#waiver-liability">Waiver Content & Liability</a></li>
        <li><a href="#data-privacy">Data & Privacy</a></li>
        <li><a href="#dpa">Data Processing Terms (DPA)</a></li>
        <li><a href="#intellectual-property">Intellectual Property</a></li>
        <li><a href="#limitation">Limitation of Liability</a></li>
        <li><a href="#indemnification">Indemnification</a></li>
        <li><a href="#termination">Termination</a></li>
        <li><a href="#disputes">Dispute Resolution</a></li>
        <li><a href="#changes">Changes to Terms</a></li>
        <li><a href="#contact">Contact Information</a></li>
    </ol>
</nav>

<section id="acceptance">
    <h2>1. Acceptance of Terms</h2>
    <p>By accessing or using SignShield ("Service"), you agree to be bound by these Terms of Service ("Terms"). If you are using the Service on behalf of an organization, you represent that you have the authority to bind that organization to these Terms.</p>
    <p>You must be at least 18 years old to use this Service. By using SignShield, you represent and warrant that you meet this age requirement.</p>
</section>

<section id="description">
    <h2>2. Description of Service</h2>
    <p>SignShield is a multi-tenant SaaS platform that enables businesses to:</p>
    <ul>
        <li>Create and manage customizable waiver templates</li>
        <li>Collect legally-binding electronic signatures with video consent verification</li>
        <li>Organize events and track participant waiver status</li>
        <li>Generate PDF records with signature and video evidence</li>
        <li>Send automated signing links and reminders</li>
    </ul>
    <p>The Service is provided on a subscription basis with various plan tiers offering different features and usage limits.</p>
</section>

<section id="registration">
    <h2>3. Account Registration</h2>
    <p>To use SignShield, you must create an account and provide accurate, complete, and current information. You are responsible for:</p>
    <ul>
        <li>Maintaining the confidentiality of your account credentials</li>
        <li>All activities that occur under your account</li>
        <li>Notifying us immediately of any unauthorized access</li>
    </ul>
    <p>Each business may maintain one tenant account. Multiple accounts for the same business are not permitted without prior authorization.</p>
</section>

<section id="billing">
    <h2>4. Subscription Plans & Billing</h2>
    <p>SignShield offers multiple subscription tiers with varying features and usage limits. By subscribing to a paid plan, you agree to:</p>
    <ul>
        <li>Pay all applicable fees as described in your selected plan</li>
        <li>Provide valid payment information</li>
        <li>Authorize recurring charges based on your billing cycle</li>
    </ul>
    <p><strong>Refund Policy:</strong> [To be defined - requires legal review]</p>
    <p>Plan changes take effect at the start of the next billing cycle. Downgrades may result in loss of access to certain features.</p>
</section>

<section id="acceptable-use">
    <h2>5. Acceptable Use Policy</h2>
    <p>You agree to use SignShield only for lawful purposes. You may NOT:</p>
    <ul>
        <li>Use the Service for any illegal activity</li>
        <li>Upload malicious code, viruses, or harmful content</li>
        <li>Attempt to gain unauthorized access to our systems</li>
        <li>Interfere with or disrupt the Service</li>
        <li>Create waivers for illegal activities</li>
        <li>Collect signatures from minors without parental consent where required by law</li>
        <li>Use the Service in violation of any applicable laws or regulations</li>
    </ul>
</section>

<section id="waiver-liability">
    <h2>6. Waiver Content & Liability</h2>
    <p><strong>Important:</strong> You are solely responsible for the content of your waiver templates and their legal enforceability in your jurisdiction.</p>
    <p>SignShield provides a platform for collecting electronic signatures and video consent. We do NOT:</p>
    <ul>
        <li>Provide legal advice</li>
        <li>Guarantee the enforceability of any waiver</li>
        <li>Review waiver content for legal compliance</li>
        <li>Accept liability for claims arising from your waiver content</li>
    </ul>
    <p>We strongly recommend having your waiver templates reviewed by qualified legal counsel before use.</p>
</section>

<section id="data-privacy">
    <h2>7. Data & Privacy</h2>
    <p>Your use of SignShield is also governed by our <a href="{% url 'privacy' %}" target="_blank">Privacy Policy</a>, which describes how we collect, use, and protect your data and the data of your signers.</p>
    <p>You are responsible for ensuring your use of SignShield complies with applicable privacy laws in your jurisdiction, including obtaining necessary consents from signers.</p>
</section>

<section id="dpa">
    <h2>8. Data Processing Terms (DPA)</h2>
    <p><em>This section serves as the Data Processing Agreement for GDPR and other data protection law compliance:</em></p>

    <h3>8.1 Roles and Responsibilities</h3>
    <p>For the purposes of data protection law:</p>
    <ul>
        <li><strong>You (Customer)</strong> are the Data Controller for signer personal data</li>
        <li><strong>SignShield</strong> is the Data Processor, processing data on your behalf</li>
    </ul>

    <h3>8.2 Processing Scope</h3>
    <p>SignShield processes personal data only as necessary to provide the Service and as documented in this Agreement. We do not sell, rent, or share signer data for marketing purposes.</p>

    <h3>8.3 Sub-processors</h3>
    <p>You authorize SignShield to use sub-processors as listed in our <a href="{% url 'privacy' %}#sub-processors" target="_blank">Privacy Policy</a>. We will notify customers of changes to sub-processors via email at least 30 days in advance.</p>

    <h3>8.4 Security Measures</h3>
    <p>SignShield implements appropriate technical and organizational security measures, including:</p>
    <ul>
        <li>Encryption in transit (TLS 1.2+) and at rest</li>
        <li>Access controls and authentication</li>
        <li>Regular security audits and monitoring</li>
        <li>Employee training on data protection</li>
    </ul>

    <h3>8.5 Data Breach Notification</h3>
    <p>In the event of a confirmed data breach affecting your data, SignShield will notify you within 72 hours of becoming aware of the breach, providing details necessary for you to fulfill your notification obligations.</p>

    <h3>8.6 Data Subject Requests</h3>
    <p>SignShield will assist you in responding to data subject requests (access, rectification, erasure, portability, etc.) to the extent technically feasible.</p>

    <h3>8.7 Data Deletion</h3>
    <p>Upon termination of your account, your data will be deleted within 90 days, unless retention is required by law or you request a data export.</p>

    <h3>8.8 Audit Rights</h3>
    <p>Enterprise customers may request compliance documentation and, upon reasonable notice, conduct audits or inspections related to SignShield's data processing activities.</p>

    <h3>8.9 International Transfers</h3>
    <p>Where personal data is transferred internationally, such transfers are governed by Standard Contractual Clauses or other approved mechanisms as applicable.</p>

    <p><strong>Enterprise DPA:</strong> Customers requiring a standalone Data Processing Agreement may contact <a href="mailto:legal@signshield.io">legal@signshield.io</a>.</p>
</section>

<section id="intellectual-property">
    <h2>9. Intellectual Property</h2>
    <p><strong>SignShield Ownership:</strong> The Service, including all software, designs, trademarks, and documentation, is owned by SignShield and protected by intellectual property laws.</p>
    <p><strong>Your Content:</strong> You retain ownership of your waiver templates, logos, and other content you upload. You grant SignShield a limited license to use this content solely to provide the Service.</p>
    <p><strong>Signer Content:</strong> Signatures, videos, and other data submitted by signers belong to the respective signers, with you as the data controller.</p>
</section>

<section id="limitation">
    <h2>10. Limitation of Liability</h2>
    <p>THE SERVICE IS PROVIDED "AS IS" WITHOUT WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED.</p>
    <p>TO THE MAXIMUM EXTENT PERMITTED BY LAW, SIGNSHIELD SHALL NOT BE LIABLE FOR:</p>
    <ul>
        <li>Indirect, incidental, special, consequential, or punitive damages</li>
        <li>Loss of profits, revenue, data, or business opportunities</li>
        <li>The enforceability or legal effect of any waiver</li>
        <li>Actions or claims by third parties against you</li>
    </ul>
    <p>Our total liability shall not exceed the amount paid by you for the Service in the 12 months preceding the claim.</p>
</section>

<section id="indemnification">
    <h2>11. Indemnification</h2>
    <p>You agree to indemnify, defend, and hold harmless SignShield and its officers, directors, employees, and agents from any claims, damages, losses, or expenses (including reasonable legal fees) arising from:</p>
    <ul>
        <li>Your use of the Service</li>
        <li>Your waiver content</li>
        <li>Your violation of these Terms</li>
        <li>Your violation of any third-party rights</li>
        <li>Claims by your signers related to waivers you created</li>
    </ul>
</section>

<section id="termination">
    <h2>12. Termination</h2>
    <p><strong>By You:</strong> You may cancel your subscription at any time through your account settings. Cancellation takes effect at the end of the current billing period.</p>
    <p><strong>By SignShield:</strong> We may suspend or terminate your account for violation of these Terms, non-payment, or other reasons at our discretion, with notice where feasible.</p>
    <p><strong>Effect of Termination:</strong> Upon termination:</p>
    <ul>
        <li>Your access to the Service will cease</li>
        <li>You will have 30 days to export your data</li>
        <li>Data will be deleted within 90 days of termination</li>
        <li>Outstanding fees remain due</li>
    </ul>
</section>

<section id="disputes">
    <h2>13. Dispute Resolution</h2>
    <p><strong>Governing Law:</strong> These Terms are governed by the laws of [Jurisdiction - to be determined], without regard to conflict of law principles.</p>
    <p><strong>Dispute Process:</strong> Before initiating formal proceedings, you agree to contact us at <a href="mailto:legal@signshield.io">legal@signshield.io</a> to attempt resolution.</p>
    <p>[Arbitration clause - to be determined after legal review]</p>
</section>

<section id="changes">
    <h2>14. Changes to Terms</h2>
    <p>We may update these Terms from time to time. We will notify you of material changes by:</p>
    <ul>
        <li>Posting the updated Terms on this page</li>
        <li>Updating the "Last Updated" date</li>
        <li>Sending email notification for significant changes</li>
    </ul>
    <p>Continued use of the Service after changes take effect constitutes acceptance of the revised Terms.</p>
</section>

<section id="contact">
    <h2>15. Contact Information</h2>
    <p>For questions about these Terms of Service:</p>
    <ul>
        <li><strong>Legal inquiries:</strong> <a href="mailto:legal@signshield.io">legal@signshield.io</a></li>
        <li><strong>General support:</strong> <a href="mailto:support@signshield.io">support@signshield.io</a></li>
        <li><strong>Mailing address:</strong> [To be added]</li>
    </ul>
</section>
{% endblock legal_content %}
```

## 7.3 Signup Agreement Component

**Note:** The signup form is defined in `tenant_self_registration.md`. The existing `accept_terms` checkbox already handles this:

```html
<!-- templates/registration/signup.html (from tenant_self_registration.md) -->
<div class="form-group checkbox-group">
    {{ form.accept_terms }}
    <label for="id_accept_terms">
        I agree to the <a href="{% url 'terms' %}" target="_blank">Terms of Service</a>
        and <a href="{% url 'privacy' %}" target="_blank">Privacy Policy</a>
    </label>
    {% if form.accept_terms.errors %}
    <span class="error-text">{{ form.accept_terms.errors.0 }}</span>
    {% endif %}
</div>
```

## 7.4 Legal Acceptance Recording

**Note:** Acceptance is recorded in `tenant_self_registration.md` during the `VerifyEmailView.create_account()` method. See Section 3.7 above for the implementation.

The `get_client_ip()` utility is defined in `apps/core/utils.py`:

```python
# apps/core/utils.py
def get_client_ip(request):
    """Get client IP address, accounting for proxies."""
    x_forwarded_for = request.META.get('HTTP_X_FORWARDED_FOR')
    if x_forwarded_for:
        ip = x_forwarded_for.split(',')[0].strip()
    else:
        ip = request.META.get('REMOTE_ADDR')
    return ip
```

---

# TODO Items for Content Development

- [ ] Consult with legal counsel for content drafting
- [ ] Define specific liability limitations
- [ ] Define refund policy details
- [ ] Define data retention periods
- [ ] Determine governing law jurisdiction
- [ ] Decide on arbitration vs. litigation
- [ ] Review industry-specific requirements (waivers, e-signatures)
- [ ] Create standalone DPA template for Enterprise customers

---

# Changelog

## v1.3 - 2025-12-25
- Updated to unified legal acceptance model
  - Single checkbox covers both ToS and Privacy Policy
  - New TenantUser fields: `legal_accepted_at`, `tos_version_accepted`, `privacy_version_accepted`, `legal_acceptance_ip`
  - Added `record_legal_acceptance()` method
  - Acceptance recorded during tenant_self_registration flow
- Updated acceptance criteria for unified approach

## v1.2 - 2025-12-25
- Added Section 7: Django Implementation for Claude Code
  - Terms of Service template (terms.html) with full content
  - Signup agreement checkbox component
  - ToS acceptance recording logic with IP address capture
  - Reference to shared infrastructure in privacy_policy.md

## v1.1 - 2025-12-24
- Added Section 8: Data Processing Terms (DPA) for GDPR compliance
  - Controller/Processor roles
  - Sub-processor authorization
  - Security measures
  - Breach notification (72 hours)
  - Data deletion timeline
  - Audit rights
  - International transfer terms
- Updated section numbering (8-15)
- Added contact emails (legal@, support@)
- Added DPA acceptance criteria

## v1.0 - 2025-12-23
- Initial draft specification

---
*End of Specification*
