# AI-Powered Furniture Landing Page Generator
 
A dynamic web application that lets users generate custom furniture landing pages using AI. Users select preferences such as furniture type, style, and budget, and the application communicates with an n8n workflow and Gemini AI via a secure PHP proxy backend to generate fully customized, visually appealing webpages on demand.
 
---

## Tech Stack

| Category             | Technologies Used                                         |
|---------------------|-----------------------------------------------------------|
| Front-End           | HTML, CSS, JavaScript                                     |
| Back-End / Proxy    | PHP                                                       |
| AI / Workflow       | n8n, AI (Gemini), Webhook                                  |
| Cloud / Deployment  | AWS Elastic Beanstalk, AWS EC2, AWS CodePipeline          |
| Security / Access   | AWS IAM, Server-side Proxy, Environment Variables        |

---
 
## Objectives
 
- Architect a client-server application with a PHP frontend and a server-side proxy.
- Interface with an external AI service (n8n/Gemini) for dynamic content generation.
- Solve Cross-Origin Resource Sharing (CORS) issues using a secure server-side proxy pattern.
- Hide sensitive API keys and webhook URLs from the client-side code.
- Implement a seamless, responsive user experience with clear loading states and asynchronous operations.
 
---
 
## Steps & Architecture
 
1.  **Frontend UI & Data Capture:**
    - The user interacts with a responsive form (`index.php`) built with HTML5 and Bootstrap.
    - Client-side JavaScript (`script.js`) captures the user's selections for furniture type, budget, and style upon form submission.
 
2.  **Client-Side Request to Proxy:**
    - Instead of calling the n8n webhook directly (which would expose the URL and cause CORS errors), the JavaScript sends a `fetch` request to a local PHP script: `generate.php`.
    - The user's selections are sent as a JSON payload in the request body.
 
3.  **Server-Side Proxy Logic (`generate.php`):** 
    - This PHP script acts as a secure backend proxy.
    - It retrieves the secret n8n webhook URL from a server environment variable (for production) or a local `config.local.php` file (for development).
    - It uses **cURL** to forward the exact request from the client to the actual n8n webhook.
 
4.  **n8n Workflow & AI Generation:**
    - The n8n workflow is triggered by the webhook call from the proxy.
    - It takes the user's preferences, passes them to the Gemini AI model, and instructs it to generate a complete HTML landing page.
    - The workflow returns the raw HTML as the response.
 
5.  **Response Handling & Dynamic Rendering:**
    - The `generate.php` proxy receives the HTML response from n8n and echoes it back to the client-side JavaScript.
    - The `fetch` call resolves, and the received HTML is dynamically injected into the result container, instantly displaying the generated page to the user.
 
---
 
## Commands & Code Snippet
 
### Local Development Setup:
```bash
# 1. Clone the repository
git clone https://github.com/janmaaarc/ai-powered-furniture-page.git
cd ai-powered-furniture

# 2. Create local configuration from the example
cp config.example.php config.local.php

# 3. (Edit config.local.php to add your webhook URL)

# 4. Run the local PHP server
php -S localhost:8000
```

### Key PHP Logic (Server-Side Proxy):
This script is the core of the backend, securely forwarding requests to the AI service.
```php
// /generate.php

// Retrieve the secret webhook URL from a server environment or local file
$webhookUrl = getenv('N8N_WEBHOOK_URL') ?: (require 'config.local.php');

// Get the raw POST data from the client-side JavaScript
$clientData = file_get_contents('php://input');

// Forward the request to the n8n webhook using cURL
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $clientData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/plain']);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Echo the response from n8n directly back to the client
http_response_code($httpcode);
echo $response;
```

---

## Notes / Lessons Learned
- **CORS & Security:** Directly calling a third-party webhook from the client is insecure and often blocked by browser CORS policies. The server-side proxy pattern is a robust solution that solves both problems by hiding the secret URL and ensuring all requests originate from the same domain.
- **Environment Variables:** Using `getenv()` for production and a local `.php` config file for development is a standard, flexible practice for managing sensitive data like API keys and URLs.
- **Asynchronous UX:** The combination of `async/await` in JavaScript and a responsive proxy ensures the UI remains active and provides clear feedback to the user during the AI generation process, which can take several seconds.

---

## File Structure

```text
├── images/                 # Application screenshots and architecture diagrams.
├── .gitignore              # Specifies intentionally untracked files to ignore.
├── 01-main.config          # AWS Elastic Beanstalk configuration for deployment.
├── README.md               # You are here!
├── config.example.php      # Example local configuration.
├── generate.php            # Server-side proxy to handle n8n webhook requests.
├── index.php               # Main PHP file that renders the application UI.
├── script.js               # Handles form submission and UI updates.
└── style.css               # Custom CSS for styling the application.
```

---

## Screenshots

### Architecture Diagram
![Architecture Diagram](images/ai_furniture_architecture.png)

### n8n Workflow
![n8n Workflow](images/n8n.png)

### Application UI
![Application UI](images/ui.png)
