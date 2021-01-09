<html lang="en">
<head>
    <style>
        /**
 * Eric Meyer's Reset CSS v2.0 (http://meyerweb.com/eric/tools/css/reset/)
 * http://cssreset.com
 */
        html, body, div, span, applet, object, iframe,
        h1, h2, h3, h4, h5, h6, p, blockquote, pre,
        a, abbr, acronym, address, big, cite, code,
        del, dfn, em, img, ins, kbd, q, s, samp,
        small, strike, strong, sub, sup, tt, var,
        b, u, i, center,
        dl, dt, dd, ol, ul, li,
        fieldset, form, label, legend,
        table, caption, tbody, tfoot, thead, tr, th, td,
        article, aside, canvas, details, embed,
        figure, figcaption, footer, header, hgroup,
        menu, nav, output, ruby, section, summary,
        time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }
        /* HTML5 display-role reset for older browsers */
        article, aside, details, figcaption, figure,
        footer, header, hgroup, menu, nav, section {
            display: block;
        }
        body {
            line-height: 1;
        }
        ol, ul {
            list-style: none;
        }
        blockquote, q {
            quotes: none;
        }
        blockquote:before, blockquote:after,
        q:before, q:after {
            content: '';
            content: none;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .clearfix:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;
        }
        .clearfix { display: inline-block; }
        /* start commented backslash hack \*/
        * html .clearfix { height: 1%; }
        .clearfix { display: block; }
        /* close commented backslash hack */
    </style>
    <style>
        html, body{
            height:100%;
        }
        .bg-dark{
            text-align: center;
            background: #444 ;
            background-size:100%;
            padding-bottom: 20px;
        }
        .main{
            font-family: 'Montserrat', sans-serif;
            font-size:90px;
            font-weight:700;
            text-transform: uppercase;
            width:100%;
            padding-top:30px;
            text-align: center;
            color:#fff;
            -moz-animation:bounce .40s linear;
            -webkit-animation:bounce .40s linear;
        }
        .sub{
            font-family: 'Montserrat', sans-serif;
            font-size: 30px;
            text-transform: uppercase;
            font-weight:700;
            padding-top: 10px;
            width:100%;
            text-align: center;
            z-index: 1;
            color:#fff;
        }
        .gt-logo{
            background: url('/img/t-night/gt_logo.png');
            width:100px;
            height:60px;
            display: block;
            margin:60px auto 0 auto;
        }
        .scroll-down{
            width:40px;
            height:40px;
            background: url('/img/t-night/scroll_down_arrow.png') ;
            position:absolute;
            bottom:0px;
            left:50%;
            margin-left:-20px;
            z-index: 1;
        }
        .highlight{
            color:#CBB57C;
        }

        #wrapper{
            width:100%;
            position:relative;
        }
        .container{
            font-family: 'Montserrat', sans-serif;
            width:80%;
            margin: 0 auto;
            z-index: 1;
        }
        .button {
            background-color: #CBB57C;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            border-radius: 8px;
            border: none;
            margin-left: 60px;
            margin-bottom: 30px;
            margin-top: 30px;
            position:relative;
            width: 275px;
            font-family: 'Montserrat', sans-serif;
        }
        #intro{
            padding-top:30px;
            margin-bottom:20px;
            padding-bottom:20px;
        }
        #invitation{
            font-size: 34px;
            color:#444;
            width:100%;
            text-align: center;
            line-height: 36px;
            font-weight:600;
            padding-bottom: 0px;
        }

        h2{
            font-size:26px;
            color:#CBB57C;
            margin-bottom: 15px;
        }
        p{
            margin-bottom: 15px;
        }
        #schedule li{
            padding: 7px;
            font-size: 17px;
        }
        #history{
            color:#444;
            line-height: 27px;
        }

        .sponsor{
            text-align: center;
        }
        #reck-club{
            background:url('/img/t-night/reck-club.png');
        }
        #tiffs{
            background:url('/img/t-night/tiffsFinal.png');
        }
        #gusto{
            background:url('/img/t-night/gusto.png');
        }
        #king{
            background:url('/img/t-night/kingofpops.png');
        }
        #gtaa{
            background:url('/img/t-night/gtaa.png');
        }
        #waho{
            background:url('/img/t-night/waho.png');
        }
        #wings{
            background:url('/img/t-night/wings.png');
        }
        #chik{
            background:url('/img/t-night/chik.png');
        }
        #bj{
            background:url('/img/t-night/bj.png');
        }
        #parent{
            background:url('/img/t-night/parents_fund.png');
        }
        footer{
            text-align: center;
            color:#AAA;
            padding:10px 0;
        }

        @-moz-keyframes bounce {
            0%{ -moz-transform:scale(0); opacity:0;}
            50%{ -moz-transform:scale(1.3); opacity:0.4; }
            75%{ -moz-transform:scale(0.9); opacity:0.7;}
            100%{ -moz-transform:scale(1); opacity:1;}
        }

        @-webkit-keyframes bounce {
            0%{ -webkit-transform:scale(0); opacity:0;}
            50%{ -webkit-transform:scale(1.3); opacity:0.4;}
            75%{ -webkit-transform:scale(0.9); opacity:0.7;}
            100%{ -webkit-transform:scale(1); opacity:1;}
        }
    </style>
    <style>
        /*
        * Skeleton V1.2
        * Copyright 2011, Dave Gamache
        * www.getskeleton.com
        * Free to use under the MIT license.
        * http://www.opensource.org/licenses/mit-license.php
        * 6/20/2012
        */

        /* Table of Content
        ==================================================
            #Site Styles
            #Page Styles
            #Media Queries
            #Font-Face */

        /* #Site Styles
        ================================================== */

        /* #Page Styles
        ================================================== */

        /* #Media Queries
        ================================================== */

        /* Smaller than standard 960 (devices and browsers) */
        @media only screen and (max-width: 959px) {
            .main{
            //padding-top:70px;
                font-size: 157px;
            }
        }

        /* Tablet Portrait size to standard 960 (devices and browsers) */
        @media only screen and (min-width: 768px) and (max-width: 959px) {
            .main{
                font-size: 152px;
            }
            .sub{
                font-size: 32px;
            }
        }

        /* All Mobile Sizes (devices and browser) */
        @media only screen and (max-width: 767px) {
            .main{
                font-size: 109px;
            }
            .sub{
                font-size: 24px;
            }
        }

        /* Mobile Landscape Size to Tablet Portrait (devices and browsers) */
        @media only screen and (min-width: 480px) and (max-width: 767px) {
            #banner-wrap{
                height:300px;
                background-position: top;
            }
            #banner{
                position: relative;

            }
            .gt-logo{
                display: none;
            }
            .main{
                font-size: 60px;
                padding-top:100px;
            }
            #invitation, #schedule{
                width:90%;
            }
            #schedule{
                margin-top: 30px;
                text-align: center;
            }
            .container{
                width:90%;
            }
            .sponsor{
                margin:0px;
            }



        }

        /* Mobile Portrait Size to Mobile Landscape Size (devices and browsers) */
        @media only screen and (max-width: 479px) {

            #banner-wrap{
                height:300px;
                background-position: top;
            }
            #banner{
                position: relative;

            }
            .gt-logo{
                display: none;
            }
            .main{
                font-size: 60px;
                padding-top:100px;
            }
            #invitation, #schedule{
                width:100%;
            }
            #schedule{
                margin-top: 30px;
                text-align: center;
            }
            .container{
                width:90%;
            }
            .sponsor{
                margin:0px;
            }
        }


        /* #Font-Face
        ================================================== */
        /* 	This is the proper syntax for an @font-face file
                Just create a "fonts" folder at the root,
                copy your FontName into code below and remove
                comment brackets */

        /*	@font-face {
                font-family: 'FontName';
                src: url('../fonts/FontName.eot');
                src: url('../fonts/FontName.eot?iefix') format('eot'),
                     url('../fonts/FontName.woff') format('woff'),
                     url('../fonts/FontName.ttf') format('truetype'),
                     url('../fonts/FontName.svg#webfontZam02nTh') format('svg');
                font-weight: normal;
                font-style: normal; }
        */
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script src="/js/jquery-3.2.1.min.js"></script><style></style>
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <title>Tradition Keepers</title>
</head>
<body style="">
<div id="wrapper">
    <div class="bg-dark">
        <div class="main">Tradition Keepers</div>
        <div class="sub">Participate in traditions. <span class="highlight">Submit photos.</span> Win prizes.</div>
    </div>
    <div class="container">

        <button class="button" onclick="window.location.href='https://docs.google.com/document/d/1e87hYj82Iq7S8y3JaOTsgdgKqw4uA2y_YsaLxv8BSBM/edit?usp=sharing';">Traditions Checklist</button>

        <button class="button" onclick="window.location.href='https://gatech.campuslabs.com/engage/submitter/form/start/453661';">Submit a Tradition</button>

        <button class="button" onclick="window.location.href='https://docs.google.com/document/d/1jjwOSCR-S3jLyGq6DaLLPIXChuH6GIfLy1kf7QSagdE/edit?usp=sharing';">Prizes and Tiers</button>

    </div>

    <div class="container">

        <div id="history">
            <h2>What is the Tradition Keepers program?</h2>
            <p>The Tradition Keepers program is a collaboration between the Ramblin' Reck Club and the Georgia Tech Alumni Association that aims to foster campus-wide participation in our cherished school traditions! By submitting photos as you and your friends complete various traditions and challenges, you can qualify for a number of different prizes and keep Tech traditions going strong.
            </p>
            <p></p>
        </div>

        <div id="history">
            <h2>How can I participate?</h2>
            <p>Getting started is easy! All you have to do is participate in an eligible tradition and submit a photo of yourself completing it. Various rotating prizes are available for people who complete different numbers of traditions during their time at Tech. The list of eligible traditions, the form to submit your completed traditions, and a list of current prizes can be found at the top of this page.
            </p>
            <p></p>
        </div>

    </div>


    <div class="container">
        <div id="history">
            <h2>Who do I contact if I have a question or want to suggest including a new tradition?</h2>
            <p>For any questions or suggestions, send an email to <a href="mailto:help@reckclub.org?" style="color:#CBB57C">help@reckclub.org</a> and be sure to mention Tradition Keepers in the subject line. We are always looking to expand the list of traditions, so let us know if we missed any! Communications about when and where to pick up prizes will also come from this address.
            </p>
            <p></p>
        </div>


    </div>

    <div class="container">
        <footer>© Copyright <?php echo date('Y'); ?> Ramblin' Reck Club. All Rights Reserved.</footer>
    </div>
</div>

</body></html>