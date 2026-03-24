<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job App</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f5f5f5;
            color: #1f1f1f;
        }

        header {
            background: linear-gradient(90deg, #1b1f2a, #2a2f3a);
            color: white;
            padding: 24px 40px;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
        }

        main {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .job-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
            border-left: 6px solid #f26b1d;
        }

        .job-card h2,
        .job-card h1 {
            margin-top: 0;
            margin-bottom: 16px;
        }

        .job-card p {
            line-height: 1.6;
            margin: 10px 0;
        }

        a {
            color: #f26b1d;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
        }

        .pagination {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<header>
    <h1>Jobbörse</h1>
</header>

<main>
    @yield('content')
</main>
</body>
</html>
