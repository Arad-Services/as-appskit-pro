<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php esc_html_e( 'You are Offline', 'as-appskit-pro' ); ?></title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            text-align: center;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 50px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            box-sizing: border-box;
        }
        h1 {
            color: #555;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.1em;
            line-height: 1.6;
            max-width: 600px;
            margin-bottom: 30px;
        }
        .offline-icon {
            font-size: 5em;
            color: #999;
            margin-bottom: 30px;
        }
        a {
            color: #0073aa;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="offline-icon">
        &#x1F4E0; </div>
    <h1><?php esc_html_e( 'You are currently offline!', 'as-appskit-pro' ); ?></h1>
    <p><?php esc_html_e( 'It seems you are not connected to the internet. Please check your connection and try again.', 'as-appskit-pro' ); ?></p>
    <p><?php esc_html_e( 'Some content might be available if it was cached during your last visit.', 'as-appskit-pro' ); ?></p>
    <p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go to Homepage', 'as-appskit-pro' ); ?></a></p>
</body>
</html>