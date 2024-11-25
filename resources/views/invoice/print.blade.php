<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print PDF</title>
    <style>
    /* Scale content to fit the page size */
    body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        zoom: 1.25; /* Adjust the scale factor as needed */
    }
</style>
</head>
<body onload="window.print()">
    <iframe src="{{ $pdfUrl }}" width="100%" height="100%" style="border: none;"></iframe>
</body>
</html>
