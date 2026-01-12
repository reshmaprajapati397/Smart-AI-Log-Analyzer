<?php
/*
Plugin Name: Smart AI Log Analyzer
Description: It will analyze debug.log error by ai 
Version: 1.0
Author: Reshma
*/


add_action('admin_menu', 'ala_create_menu');
function ala_create_menu() {
    add_menu_page('AI Log Analyzer', 'AI Analyzer', 'manage_options', 'ai-log-analyzer', 'ala_settings_page', 'dashicons-Ai', 100);
}


add_action('admin_init', 'ala_register_settings');
function ala_register_settings() {
    register_setting('ala-settings-group', 'ala_gemini_api_key');
}


function ala_settings_page() {
    ?>
    <div class="wrap">
        <h1>Smart AI Log Analyzer</h1>
        <form method="post" action="options.php">
            <?php settings_fields('ala-settings-group'); ?>
            <table class="form-table">
                <tr>
                    <th>Gemini API Key</th>
                    <td><input type="text" name="ala_gemini_api_key" value="<?php echo esc_attr(get_option('ala_gemini_api_key')); ?>" style="width:400px;" /></td>
                </tr>
            </table>
            <?php submit_button('Save API Key'); ?>
        </form>

        <hr>

        <h2>Analyze Errors</h2>
        <form method="post">
            <input type="submit" name="analyze_now" class="button button-primary" value="Analyze Latest Errors">
        </form>

        <?php
        if (isset($_POST['analyze_now'])) {
            echo '<h3>AI Analysis Report:</h3>';
            echo '<div style="background:#fff; padding:20px; border-left:4px solid #0073aa; white-space: pre-wrap;">';
            echo ala_run_analysis();
            echo '</div>';
        }
        ?>
    </div>
    <?php
}


function ala_run_analysis() {
    $api_key = get_option('ala_gemini_api_key');
    if (!$api_key) return "Please save the API Key first.";

    $log_path = WP_CONTENT_DIR . '/debug.log';
    if (!file_exists($log_path)) return "The debug.log file was not found. Enable WP_DEBUG_LOG in wp-config.php.";

  
    $log_content = shell_exec("tail -n 10 " . escapeshellarg($log_path));
    
    $prompt = "You are an expert PHP/WordPress developer. Analyze these logs and explain what is wrong and how to fix it step-by-step: \n" . $log_content;

    return ala_call_gemini($api_key, $prompt);
}


function ala_call_gemini($api_key, $prompt) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $api_key;
    $data = ["contents" => [["parts" => [["text" => $prompt]]]]];

    $response = wp_remote_post($url, [
        'body' => json_encode($data),
        'headers' => ['Content-Type' => 'application/json'],
        'timeout' => 30
    ]);

    if (is_wp_error($response)) return "Error: " . $response->get_error_message();

    $body = json_decode(wp_remote_retrieve_body($response), true);
    return $body['candidates'][0]['content']['parts'][0]['text'] ?? "AI રિસ્પોન્સમાં ભૂલ છે.";
}