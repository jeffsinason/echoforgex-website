# /wp-deploy - WordPress Deployment Helper

Deploy theme files and configurations to the production server.

## Usage

```
/wp-deploy theme    - Deploy theme files to server
/wp-deploy check    - Check server status and WordPress health
/wp-deploy backup   - Trigger a backup before deployment
```

---

## Deploy Theme: `/wp-deploy theme`

Deploy the local theme to the production server.

### Prerequisites
- SSH access to Linode server configured
- WordPress installed at `/var/www/echoforgex.com/public_html/`

### Process

1. **Verify local theme files exist:**
   ```
   wp-content/themes/echoforgex-theme/
   ├── style.css
   ├── functions.php
   └── assets/
   ```

2. **Show files that will be deployed:**
   List all files in the theme directory

3. **Confirm with user:**
   "Ready to deploy theme to echoforgex.com. Continue?"

4. **Deploy via rsync:**
   ```bash
   rsync -avz --delete \
     wp-content/themes/echoforgex-theme/ \
     user@server:/var/www/echoforgex.com/public_html/wp-content/themes/echoforgex-theme/
   ```

5. **Clear caches (if applicable):**
   - Clear WP Super Cache
   - Purge Cloudflare cache

6. **Verify deployment:**
   - Check that theme is active in WordPress
   - Quick visual check of homepage

---

## Check Server: `/wp-deploy check`

Verify server and WordPress health.

### Checks to perform:

1. **Server connectivity:**
   ```bash
   ssh user@server "echo 'Connected'"
   ```

2. **WordPress status:**
   ```bash
   ssh user@server "cd /var/www/echoforgex.com/public_html && wp core version"
   ```

3. **Theme status:**
   ```bash
   ssh user@server "cd /var/www/echoforgex.com/public_html && wp theme status"
   ```

4. **Plugin status:**
   ```bash
   ssh user@server "cd /var/www/echoforgex.com/public_html && wp plugin list --status=active"
   ```

5. **Disk space:**
   ```bash
   ssh user@server "df -h /var/www/echoforgex.com"
   ```

6. **Recent errors:**
   ```bash
   ssh user@server "tail -20 /var/www/echoforgex.com/logs/error.log"
   ```

---

## Backup: `/wp-deploy backup`

Trigger a backup before making changes.

1. **Database backup:**
   ```bash
   ssh user@server "cd /var/www/echoforgex.com/public_html && wp db export ../backups/db-$(date +%Y%m%d-%H%M%S).sql"
   ```

2. **Files backup:**
   ```bash
   ssh user@server "tar -czf /var/www/echoforgex.com/backups/files-$(date +%Y%m%d-%H%M%S).tar.gz -C /var/www/echoforgex.com/public_html wp-content"
   ```

3. **Confirm backup created:**
   ```bash
   ssh user@server "ls -la /var/www/echoforgex.com/backups/"
   ```

---

## Server Details

| Setting | Value |
|---------|-------|
| Host | [Linode IP or hostname] |
| User | [SSH user] |
| WordPress Path | /var/www/echoforgex.com/public_html |
| Theme Path | /var/www/echoforgex.com/public_html/wp-content/themes/echoforgex-theme |
| Logs | /var/www/echoforgex.com/logs/ |
| Backups | /var/www/echoforgex.com/backups/ |

---

## Notes

- Always run `/wp-deploy backup` before major deployments
- Test changes locally before deploying
- After deployment, clear browser cache and test
- If issues arise, previous theme version can be restored from backup
