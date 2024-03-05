<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>APC+</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap&_v=20230214160020"
          rel="stylesheet">
</head>

<body>

<style>
    * {
        outline: none;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    body {
        background-color: #fff;
        font-family: "Roboto", sans-serif;
        margin: 0;
        min-height: 100vh;
        scroll-behavior: smooth;
        font-size: 1rem;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .stub {
        background-color: #006DAC;
        background-image: url(../images/stub_bg.jpeg);
        background-size: cover;
        background-position: bottom right;
        width: 100%;
        min-height: 100vh;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        padding: 100px 50px 100px 17%;
        position: relative;
        color: #fff;
    }

    @media (max-width: 1800px) {
        .stub {
            padding-left: 10%;
        }
    }

    @media (max-width: 1350px) {
        .stub {
            padding-left: 40px;
            background-position: bottom left;
        }
    }

    .stub_text {
        max-width: 690px;
    }

    .stub_title {
        font-weight: 500;
        font-size: 80px;
        letter-spacing: 0.03em;
    }

    @media (max-width: 1350px) {
        .stub_title {
            font-size: 70px;
        }
    }

    @media (max-width: 768px) {
        .stub_title {
            font-size: 54px;
        }
    }

    @media (max-width: 480px) {
        .stub_title {
            font-size: 40px;
        }
    }

    .stub_title span {
        color: #62BD78;
    }

    .stub_description {
        font-size: 32px;
        line-height: 125%;
    }

    @media (max-width: 1350px) {
        .stub_description {
            font-size: 30px;
        }
    }

    @media (max-width: 768px) {
        .stub_description {
            font-size: 28px;
        }
    }

    @media (max-width: 480px) {
        .stub_description {
            font-size: 18px;
        }
    }
</style>

<main class="stub">
    <div class="stub_text">
        <h1 class="stub_title">Сайт находится в <span>разработке</span></h1>
        <span class="stub_description">Приносим свои извинения за временные неудобства. Осталось подождать совсем
        чуть-чуть</span>
    </div>
</main>


</body>

</html>