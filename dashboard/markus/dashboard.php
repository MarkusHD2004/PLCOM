<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./dashboard.css">
  <script src="./dashboard.js" defer></script>
  <title>PLCOM</title>
</head>

<body>
    <header>
        <div class="header-container">
            <label class="logo">Website</label>
            <div class="h-element-container">
                <a class="h-element" href="">
                    <img src="assets/images/ui/settings.svg">
                </a>
                <a class="h-element" href="">
                    <img src="assets/images/ui/logout.svg">
                </a>
                <a class="h-element" href="">
                    <img src="assets/images/ui/user-circle.svg">
                </a>
            </div>
        </div>
    </header>
    <aside>
        <div class="aside-header">
            <button id="slide_btn"></button>
        </div>
        <div class="main-nav">
            <div class="project">
                <div class="project-title">
                    <img src="assets/images/ui/chevron-up.svg">
                    <label>Project 1</label>
                </div>
                <button class="add-button">
                    <img src="assets/images/ui/circle-plus.svg">
                </button>
            </div>
            <div class="sps">
                <img src="assets/images/ui/devices-pc.svg">
                <label>SPS 1</label>
            </div>
            <div class="sps">
                <img src="assets/images/ui/devices-pc.svg">
                <label>SPS 2</label>
            </div>
            <div class="project">
                <div class="project-title">
                    <img src="assets/images/ui/chevron-down.svg">
                    <label>Project 2</label>
                </div>
                <button class="add-button">
                    <img src="assets/images/ui/circle-plus.svg">
                </button>
            </div>
        </div>
        <div class="add-nav" href="">
            <img src="assets/images/ui/circle-plus.svg">
        </div>
    </aside>
</body>

</html>