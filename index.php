<?php

$config = require('config.php');
require('core/database.php');

$db = new Database($config['database']);
$blogs = $db->query();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Awesome Blog</title>
    <style>
        /* Modern CSS Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Header Styles */
        .blog-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 40px 20px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            animation: slideDown 0.8s ease-out;
        }

        .blog-header h1 {
            font-size: 3em;
            color: #667eea;
            margin-bottom: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .blog-description {
            font-size: 1.2em;
            color: #666;
            font-style: italic;
        }

        /* Blog Post Cards */
        .blog-post {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 0.8s ease-out;
        }

        .blog-post:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2);
        }

        .post-title {
            font-size: 2em;
            color: #333;
            margin-bottom: 10px;
            border-left: 5px solid #667eea;
            padding-left: 15px;
        }

        .post-meta {
            color: #888;
            font-size: 0.9em;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .post-meta i {
            font-style: normal;
            background: #f0f0f0;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 0.9em;
        }

        .post-content {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 25px;
            line-height: 1.8;
        }

        /* Comments Section */
        .comments-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px dashed #e0e0e0;
        }

        .comments-title {
            font-size: 1.3em;
            color: #444;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .comments-title:before {
            content: '💬';
            font-size: 1.2em;
        }

        .comment {
            background: #f9f9f9;
            border-radius: 15px;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-left: 4px solid #764ba2;
            transition: transform 0.2s ease;
            animation: slideIn 0.5s ease-out;
        }

        .comment:hover {
            transform: translateX(5px);
            background: #f0f0f0;
        }

        .comment-author {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 8px;
            font-size: 1.1em;
        }

        .comment-author:before {
            content: '👤 ';
            font-size: 0.9em;
        }

        .comment-text {
            color: #555;
            font-size: 1em;
            line-height: 1.5;
        }

        .comment-text:before {
            content: '"';
            font-size: 1.2em;
            color: #999;
        }

        .comment-text:after {
            content: '"';
            font-size: 1.2em;
            color: #999;
        }

        /* Timestamp Styling */
        .timestamp {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #667eea10 0%, #764ba210 100%);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
        }

        .timestamp:before {
            content: '🕒';
            margin-right: 8px;
            font-size: 1em;
        }

        /* Divider */
        .post-divider {
            height: 3px;
            background: linear-gradient(90deg, transparent, #667eea, #764ba2, #667eea, transparent);
            margin: 40px 0;
            border: none;
        }

        /* Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .blog-header h1 {
                font-size: 2em;
            }

            .blog-post {
                padding: 20px;
            }

            .post-title {
                font-size: 1.5em;
            }
        }

        /* Loading Animation for Posts */
        .blog-post {
            position: relative;
            overflow: hidden;
        }

        .blog-post::after {
            display: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
    </style>
</head>
<body>
<div class="container">
    <header class="blog-header">
        <h1>BLOG TITLE</h1>
        <p class="blog-description">This article summarizes what the blog is about</p>
    </header>

    <main>
        <?php foreach ($blogs as $blog) : ?>
            <article class="blog-post">
                <h2 class="post-title"><?= htmlspecialchars($blog['title']) ?></h2>
                <h2 class="post-title"><?= htmlspecialchars($blog['post_body']) ?></h2>

                <div class="post-meta">
                    <span class="timestamp"><?= htmlspecialchars($blog['created_at']) ?></span>
                </div>

                <div class="post-content">
                    <?= nl2br(htmlspecialchars($blog['blog_body'])) ?>
                </div>

                <?php if (!empty($blog['comments'])) : ?>
                    <div class="comments-section">
                        <h3 class="comments-title">Comments</h3>
                        <?php foreach ($blog['comments'] as $comment) : ?>
                            <div class="comment">
                                <div class="comment-author">Vova</div>
                                <div class="comment-text"><?= htmlspecialchars($comment['comment_body']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
            <hr class="post-divider"/>
        <?php endforeach; ?>
    </main>
</div>
</body>
</html>