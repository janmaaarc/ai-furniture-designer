# AI Furniture Designer

A dynamic web application that allows users to generate a custom furniture landing page using AI. Users select their preferences for furniture type, budget, and style, and the application communicates with an AI backend via an n8n webhook to produce a unique, visually appealing webpage.

![AI Furniture Designer Screenshot](https://user-images.githubusercontent.com/12345/placeholder.png)

## Features

*   **Intuitive UI:** A clean and simple form to select furniture options from dropdown menus.
*   **Dynamic AI Content:** Interfaces with an n8n workflow powered by Gemini to generate custom designs on the fly.
*   **Responsive Design:** The user interface is fully responsive and works seamlessly on both desktop and mobile devices.
*   **Modern User Experience:** Features a sleek card-based layout, smooth animations, and clear loading states to provide an engaging user experience.
*   **Asynchronous Operations:** Utilizes the Fetch API and async/await for non-blocking API calls, ensuring the UI remains fast and responsive.

## How It Works

1.  The user selects their desired furniture attributes from the form on the main page.
2.  Upon clicking "Generate," the application sends the form data as a JSON payload to a predefined webhook URL.
3.  The UI transitions to a loading state, displaying an animation while it awaits the response.
4.  A backend workflow (powered by n8n) receives the data, processes it using the Gemini AI model, and returns an HTML snippet containing the generated design.
5.  The frontend receives the HTML and dynamically injects it into the page for the user to view.

## Getting Started

To get this project running on your local machine for development and testing, follow these steps.

### Prerequisites

*   A local web server environment that can run PHP.
    *   [XAMPP](https://www.apachefriends.org/index.html) (Windows, macOS, Linux)
    *   [MAMP](https://www.mamp.info/en/mamp/) (macOS, Windows)
    *   PHP's built-in web server
*   An active backend workflow (e.g., on n8n) with a webhook trigger that is configured to accept JSON data and return an HTML response.

### Installation

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/janmaaarc/ai-powered-furniture-page.git
    cd ai-powered-furniture
    ```

2.  **Configure the Webhook URL:**
    Create a new file named `config.js` in the root of the project. This file is intentionally ignored by Git (via `.gitignore`) to keep your webhook URL private. Add the following content, replacing the placeholder with your actual n8n webhook URL:

    ```javascript
    // /config.js
    window.N8N_WEBHOOK_URL = 'https://your-n8n-instance.com/webhook/your-webhook-id';
    ```

3.  **Run the application:**
    Navigate to the project directory in your terminal and start the PHP built-in server:
    ```sh
    php -S localhost:8000
    ```
    Alternatively, place the project folder in the `htdocs` or `www` directory of your XAMPP or MAMP installation and start the Apache server.

4.  **Open the Application:**
    Open your web browser and navigate to `http://localhost:8000`.

## Technologies Used

*   **Frontend:**
    *   **HTML5 & CSS3:** For structure and styling, featuring Custom Properties, Flexbox, and Keyframe Animations.
    *   **JavaScript (ES6+):** For client-side logic, including DOM manipulation, form handling, and asynchronous API calls using the Fetch API and `async/await`.
*   **Backend & Workflow:**
    *   **n8n & Gemini:** For the AI-powered backend, handling workflow automation and content generation.
*   **Development Environment:**
    *   **PHP:** Used via its built-in web server (`php -S`) for local development and serving the application.

## File Structure

```
├── index.php         # Main PHP file that renders the initial HTML and form.
├── style.css         # Custom CSS for styling the application.
├── script.js         # Handles form submission, AJAX calls, and UI updates.
├── config.js         # (Untracked) Stores the n8n webhook URL.
└── README.md         # You are here!
```