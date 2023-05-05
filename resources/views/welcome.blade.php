<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-168261576-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-168261576-1');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/main.css" />
    <noscript><link rel="stylesheet" href="css/noscript.css" /></noscript>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <title>OpenLab - Virtual Reality Laboratory Simulations | Alens XR</title>
    <meta name="description" content="OpenLab is a Virtual Reality laboratory simulation that aims to teach students specific laboratory skills, techniques, processes, and protocols."/>
    <meta name="keywords" content="Virtual Reality, Laboratory Simulation, Training, Lab, Techniques, OpenLab, Virtual, Reality, Laboratory, Simulation">
  </head>
  <body class="is-preload">
    <!-- Page Wrapper -->
        <div id="page-wrapper">
            <!-- Banner -->
                <section id="banner">
                    <div class="inner">
                        <div class="logo"><a class="image"><img src="img/alensweb1.png" height="30%" width="30%"></a></div>
                        <h2>Welcome to OpenLab</h2>
                        <p>Virtual Reality laboratory simulations</p>
                    </div>
                </section>

            <!-- Wrapper -->
                <section id="wrapper">
                    <!-- One -->
                        <section id="one" class="wrapper spotlight style1">
                            <div class="inner">
                                <a class="image"><img src="img/Pic1.png" alt="" /></a>
                                <div class="content">
                                    <h2 class="major">Product</h2>
                                    <p>OpenLab is a Virtual Reality laboratory simulation that trains students to work in a research laboratory. The software covers the steps involved in specific laboratory skills, techniques, processes, and protocols; this includes the description of the tools involved and good laboratory practices.</p>
                                </div>
                            </div>
                        </section>

                    <!-- Two -->
                        <section id="two" class="wrapper alt spotlight style2">
                            <div class="inner">
                                <a class="image"><img src="img/Pic2.png" alt="" /></a>
                                <div class="content">
                                    <h2 class="major">Objective</h2>
                                    <p>The objective is to train students to succeed during the performance of a real-life laboratory protocol and minimize the chances of safety complications. OpenLab aims to prepare the student for the real laboratory experience. Students can learn from trial and error in the virtual laboratory before interacting with a real laboratory.</p>
                                </div>
                            </div>
                        </section>

                    <!-- Three -->
                        <section id="three" class="wrapper spotlight style3">
                            <div class="inner">
                                <a class="image"><img src="img/Pic3.png" alt="" /></a>
                                <div class="content">
                                    <h2 class="major">How it works</h2>
                                    <p>Students are immersed in a virtual laboratory through a VR headset. From a menu, they can pick which laboratory experience they want to perform. Each experience has visual instructions to guide the students throughout the whole process and a whiteboard keeps track of the progress.</p>
                                </div>
                            </div>
                        </section>

                    <!-- Four -->
                        <section id="four" class="wrapper alt style1">
                            <div class="inner">
                                <h2 class="major">Features</h2>
                                <div class="iconrow">									
                                    <div class="iconbox1">
                                        <img src="img/multimedia.png" width="15%"/>
                                        <p class="icontitle">Standalone</p>
                                        <p class="icondescription">OpenLab works on standalone and portable VR headsets.</p>
                                    </div>
                                    <div class="iconbox2">
                                        <img src="img/hand.png" width="12%"/>
                                        <p class="icontitle">Hand-tracking</p>
                                        <p class="icondescription">Interaction is intuitive and easy thanks to hand-tracking technology. No controllers are needed.</p>
                                    </div>
                                </div>	
                                <div class="iconrow">									
                                    <div class="iconbox1">
                                        <img src="img/error.png" width="15%"/>
                                        <p class="icontitle">Error detection</p>
                                        <p class="icondescription">A built-in error detector corrects students whenever they make a mistake.</p>
                                    </div>
                                    <div class="iconbox2">									
                                        <img src="img/sheet.png" width="13%"/>
                                        <p class="icontitle">Exam mode</p>
                                        <p class="icondescription">Repeat techniques and protocols without any suggestion and collect the performed scores.</p>
                                    </div>
                                </div>	
                            </div>
                        </section>

            <!-- Footer -->
                <section id="footer">
                    <div class="inner">
                        <h2 class="major">Sign up to become a pilot user</h2>
                        <p>We are currently collecting emails for our first pilot users, who will have free early access to OpenLab</p>

                        <form id="mailinglist" method="post" action="api/mailinglist">
                            @csrf
                            <div class="fields">
                                <div class="field">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" />
                                    <span id="nameError" class="error"></span>
                                </div>
                                <div class="field">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" />
                                    <span id="emailError" class="error"></span>
                                </div>
                            </div>
                            <ul class="actions">
                                <li><input type="submit" value="Sign Up" /></li>
                            </ul>
                        </form>
                        <div id="successSubscribe" class="success"></div>
                        <ul class="copyright">
                            <li>&copy; Alens XR All rights reserved.</li>
                        </ul>
                    </div>
                </section>

        </div>

    <!-- Scripts -->
        
        <script src="js/jquery.scrollex.min.js"></script>
        <script src="js/browser.min.js"></script>
        <script src="js/breakpoints.min.js"></script>
        <script src="js/util.js"></script>
        <script src="js/main.js"></script>

        <script>
        jQuery(document).ready( function( $ ) {
            $('#mailinglist').on('submit', function(e) {
                e.preventDefault(); 
                var name = $('#name').val();
                var email = $('#email').val();
                $.ajax({
                    type: "POST",
                    url: 'https://www.alensxr.com/api/mailinglist',
                    data: {name:name, email:email },
                    success: function(msg) {
                        $('#emailError').toggle(false);
                        $('#nameError').toggle(false);
                        $('#successSubscribe').text("Thank you for joining. We will contact you shortly.")
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var res = JSON.parse(xhr.responseText);
                        if (res.errors.email != undefined){  
                            $('#emailError').toggle(true);   
                            $('#emailError').text(res.errors.email[0]);
                        }
                        else{
                            $('#emailError').toggle(false);
                        }
                        if (res.errors.name != undefined){   
                            $('#nameError').toggle(true);   
                            $('#nameError').text(res.errors.name[0]);
                        }else{
                            $('#nameError').toggle(false);
                        }
                    }
                });
            });
        });
        </script>

    </body>
</html>

<!--
<a href="/login" style="margin-right: 15px;">
    <button>
        {{__('Login')}}
    </button>
</a>
-->