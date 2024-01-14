<style>
    
    header
    {
        height: 50px;
        background-color: #fafafa;
        display: grid;
        grid-template-columns: auto;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
    }

    .size
    {
        font-family:'Poppins', sans-serif;
        font-size: medium !important;
        color: #212821 !important;
        max-width: 300px !important;
        letter-spacing: 1px;
    }

    .navbar-toggler
    {
        color: #212821 !important;
        border: 1px solid #212821 !important;
    }
    
    .dropdown-submenu 
    {
        position: relative;
    }

    .dropdown-submenu .dropdown-menu 
    {
        top: 0;
        left: 100%;
        margin-top: -1px;
    }

    .dropdown-item 
    {
        max-width: 300px !important;
        white-space: normal !important;
    }

    .dropdown-item:active
    {
        background-color: #f8f9fa !important;
    }

    .bg-light
    {
        background-color: #f7f7f7 !important; 
        box-shadow: 0px 5px 5px rgba(0,0,0,0.1) !important;
    }

    @media screen and (min-width:575px)
    {
        .dropdown-item 
        {
            max-width: 400px !important;
            white-space: normal !important;
        }

        .size
        {
            font-size: smaller !important;
            max-width: 400px !important;
        }   
    }

</style>

<script>
    $(document).ready(function(){
        $('.dropdown-submenu a.test').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
    });
</script>

<header>
    <nav class="navbar navbar-expand-md bg-light navbar-dark sticky-top" >
        <!-- Brand -->
        <a class="navbar-brand" href="https://centrefordefencecareers.co.in">
            <img src="images/logo.png" alt="" height='25px' width='25px'>
        </a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class=""><i class="fas fa-bars"></i></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link size" href="https://www.centrefordefencecareers.co.in/why-is-cdc-best-institute-for-nda-cds-ota-afcat-ta-training/">Why CDC</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle size" href="#" id="navbardrop" data-toggle="dropdown">
                        Entries
                    </a>
                    <ul class="dropdown-menu">
                        <li class='dropdown-item dropdown-submenu'>
                            <a class="nav-link dropdown-toggle size test" tabindex="-1" href="https://www.centrefordefencecareers.co.in/indian-army/">Indian Army</a>
                            <ul class="dropdown-menu">
                                <li class='dropdown-item'><a class='size' href="https://www.centrefordefencecareers.co.in/commissioned-3/">Commissioned Officer</a></li>
                                <li class='dropdown-item'><a class='size' href="https://www.centrefordefencecareers.co.in/non-commissioned-3/">Non Commissioned</a></li>
                            </ul>
                        </li>
                        <li class='dropdown-item dropdown-submenu'>
                            <a class="nav-link dropdown-toggle size test" tabindex="-1" href="https://www.centrefordefencecareers.co.in/indian-army/">Indian Navy</a>
                            <ul class="dropdown-menu">
                                <li class='dropdown-item'><a class='size' href="https://www.centrefordefencecareers.co.in/commissioned/">Commissioned Officer</a></li>
                                <li class='dropdown-item'><a class='size' href="https://www.centrefordefencecareers.co.in/non-commissioned/">Non Commissioned</a></li>
                            </ul>
                        </li>
                        <li class='dropdown-item dropdown-submenu'>
                            <a class="nav-link dropdown-toggle size test" tabindex="-1" href="https://www.centrefordefencecareers.co.in/indian-army/">Indian Air Force</a>
                            <ul class="dropdown-menu">
                                <li class='dropdown-item'><a class='size' href="https://www.centrefordefencecareers.co.in/commissioned-2/">Commissioned Officer</a></li>
                                <li class='dropdown-item'><a class='size' href="https://www.centrefordefencecareers.co.in/non-commissioned-4/">Non Commissioned</a></li>
                            </ul>
                        </li>
                        <li class='dropdown-item'><a class='size' href="https://www.centrefordefencecareers.co.in/para-military-forces/">Para Military Forces</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle size" href="#" id="navbardrop" data-toggle="dropdown">
                        NDA
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/nda-educational-qualification-army-navy-airforce/">NDA – Educational Qualification for Army, Navy &amp; AirForce</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/nda-age-limit/">NDA – Age Limit</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/nda-important-dates/">NDA EXAM 2019- Important Dates</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/nda-physical-medical-standards/">NDA – Physical Standards</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/nda-exam-syllabus-paper-pattern/">NDA Exam – Syllabus</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/nda-exam-paper-pattern/">NDA Exam – Paper Pattern</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/how-to-prepare-for-nda/">How to prepare for NDA</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/want-to-learn-the-best-way-to-prepare-for-nda-written-exam/">Want to Learn “The BEST Way to prepare for NDA Written Exam?”</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle size" href="#" id="navbardrop" data-toggle="dropdown">
                        CDSE
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/cdse-educational-qualification-for-ima-ina-airforce-academy-ota/">CDSE – Educational Qualification for IMA, INA, Airforce Academy, OTA</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/cdse-age-limit/">CDSE – Age Limit</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/cdse-important-dates/">CDSE 2017 (II) – Important Dates</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/cdse-physical-medical-standards/">CDSE – Physical Standards</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/cds-syllabus/">CDSE – Syllabus</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/cds-exam-paper-pattern/">CDSE – SCHEME OF EXAMINATION</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle size" href="#" id="navbardrop" data-toggle="dropdown">
                        AFCAT
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/afcat-educational-qualification-afcat/">AFCAT – Educational Qualification for AFCAT</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/afcat-physical-medical-standards/">AFCAT – Physical and Medical Standards</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/afcat-022017-age-limit/">AFCAT 02/2017 – Age Limit</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/afcat-scheme-of-syllabus/">AFCAT – Scheme of Syllabus</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/afcat-example-questions/">AFCAT – Example of Questions</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/afcat-faqs/">AFCAT – FAQ’s</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle size" href="#" id="navbardrop" data-toggle="dropdown">
                        Territory Army
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/territorial-army/">What is Territorial Army?</a></li>
                        <li class="dropdown-item"><a class='size' href="https://www.centrefordefencecareers.co.in/territorial-army-main/">Territorial Army Course at C.D.C</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link size" href="https://www.centrefordefencecareers.co.in/courses-offered-by-centre-for-defence-careers/">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link size" href="https://www.centrefordefencecareers.co.in/get-free-guidance/">Free Guidance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link size" href="https://www.centrefordefencecareers.co.in/category/blog/">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link size" href="https://www.centrefordefencecareers.co.in/gallery/">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link size" href="https://www.centrefordefencecareers.co.in/contact-us/">Contact Us</a>
                </li>
                
            </ul>
        </div>
    </nav>
</header>