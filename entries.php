<?php

session_start();

require('php_script/DBConnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['u_name'])) {
        $user_name = $_GET['u_name'];
    }

    if (!empty($_GET['dob'])) {
        $dob = $_GET['dob'];
    }

    if (!empty($_GET['gender'])) {
        $gender = $_GET['gender'];
    }

    if (!empty($_GET['qualification'])) {
        $qualification = $_GET['qualification'];
    }

    if (!empty($_GET['stream'])) {
        $stream = $_GET['stream'];
    }

    if (!empty($_GET['caste'])) {
        $caste = $_GET['caste'];
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56130809-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-56130809-1');
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Entries | CDC</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel='stylesheet' href='css/entries.css'>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

</head>

<body>
    <article>
        <?php include('header.php'); ?>
        <section id="main_section">
            <div id='head'>
                <div class='container'>
                    <img src="images/hat.svg" alt="">
                    <div>
                        <h6>Hi, <?php echo $user_name; ?></h6>
                    </div>
                </div>
            </div>

            <div id='loader'>
                <div id='loader_content'>
                    <div id='spin'>

                    </div>
                    <p>Searching entries for you..</p>
                </div>
            </div>
            <div id='category_list' class='animated fadeInUp delay-2s faster'>

            </div>
        </section>


    </article>

    <div id="overlay">
        <div id="overlay_main">
            <div id="overlay_head">
                <div id="log">
                    <img src="images/logo.png" alt="">
                </div>
                <div id="clos">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div id='overlay_body'>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        var user_name = '';
        var dob = '';
        var gender = '';
        var qualification = '';
        var stream = '';
        var caste = '';

        <?php

        if (!empty($user_name)) {
            echo "user_name = " . json_encode($user_name) . ";\n";
        }

        if (!empty($dob)) {
            echo "dob = " . json_encode($dob) . ";\n";
        }

        if (!empty($gender)) {
            echo "gender = " . json_encode($gender) . ";\n";
        }

        if (!empty($qualification)) {
            echo "qualification = " . json_encode($qualification) . ";\n";
        }

        if (!empty($stream)) {
            echo "stream = " . json_encode($stream) . ";\n";
        }

        if (!empty($caste)) {
            echo "caste = " . json_encode($caste) . ";\n";
        }

        ?>

        AOS.init();
    </script>

    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '194589760880610');
        fbq('track', 'PageView');
    </script>

    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=194589760880610&ev=PageView&noscript=1" /></noscript>

    <!-- End Facebook Pixel Code -->

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5ac22677d7591465c7091cfa/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();

        Tawk_API.onPrechatSubmit = function(data) {
            let formData = new FormData;

            formData.append('name', data[0]['answer']);
            formData.append('contact', data[1]['answer']);

            var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("POST", "https://eligibility.centrefordefencecareers.co.in/php_script/create_lead.php", true);
            xmlhttp.send(formData);

            const date = new Date();

            const formatteddate = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();

            let formGoogleSheetData = new FormData

            formGoogleSheetData.append('date', formatteddate);
            formGoogleSheetData.append('name', data[0]['answer']);
            formGoogleSheetData.append('mobile', data[1]['answer']);
            formGoogleSheetData.append('email', '-');
            formGoogleSheetData.append('location', "-");
            formGoogleSheetData.append('generated_by', "Tawk - Eligibility");

            fetch('https://script.google.com/macros/s/AKfycbyri45Ekk9Ky2JinaNzbxdLPEWSDW0jJFEeX9leDWvnlNQVNtKLIap-eMWT77EPXGi4KQ/exec', {
                method: "POST",
                body: formGoogleSheetData,
            });
        }
    </script>
    <!--End of Tawk.to Script-->

    <script src='js/entries.js'></script>
</body>

</html>