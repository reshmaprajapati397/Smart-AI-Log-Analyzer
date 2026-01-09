# Smart AI Log Analyzer

**Contributors:** Reshma  
**Tags:** ai, debug, log, error, gemini, developer tool  
**Requires at least:** 5.0  
**Tested up to:** 6.4  
**Stable tag:** 1.0  
**License:** GPLv2 or later  

Analyze your WordPress `debug.log` errors instantly using Google Gemini AI. Get step-by-step solutions for PHP errors directly in your dashboard.

## 🚀 Description

Debugging WordPress errors can be time-consuming. **Smart AI Log Analyzer** reads your WordPress `debug.log` file, identifies the latest errors, and sends them to Google's powerful **Gemini AI**.

Instead of cryptic error messages, you get:
1.  **The Root Cause:** Plain English explanation of what went wrong.
2.  **Step-by-Step Fix:** Code snippets or actions to resolve the issue.
3.  **Security Insights:** Warnings if the error poses a risk.

Perfect for developers who want to speed up their workflow or site owners who need to understand technical issues.

## ✨ Features

* **One-Click Analysis:** Analyze the latest 10 lines of your error log instantly.
* **Powered by Gemini 2.5 Flash:** Uses Google's latest fast and efficient AI model.
* **Secure API Integration:** Your API key is stored securely in the database.
* **Simple Interface:** No complex setup, just plug and play.

## 📋 Prerequisites

To use this plugin, you must enable error logging in your WordPress configuration.

1.  Open your `wp-config.php` file.
2.  Add or update the following lines:

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false ); // Optional: Hides errors from screen