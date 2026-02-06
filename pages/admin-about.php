<?php
require '../config.php';
require '../authenticator.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>FarmTechX Admin About</title>
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" href="../assets/css/about2.css" />
    <link rel="stylesheet" href="../assets/css/lowerR-bg.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../assets/images/FarmTechX.jpg" />
</head>

<body>
    <div class="main-container">
        <?php include '../assets/php/hamburder-menu.php'; ?>    
        <?php include '../assets/php/sidebar-about.php'; ?>
        
        <main class="main-content">
            <div class="content-wrapper">
                <?php include '../assets/php/welcome-card-about.php'; ?>

<!-- Baluzo Farm Section -->
<section class="mt-4 text-center">
    <h2 class="mb-3">BALUZO FARM</h2>
    <p class="fst-italic">“Naturally Grown for Healthy Living”</p>

    <!-- Card wrapper for accordion -->
  
        
        <div class="accordion" id="baluzoAccordion">

            <!-- History -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingHistory">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHistory" aria-expanded="true" aria-controls="collapseHistory">
                        History
                    </button>
                </h2>
                <div id="collapseHistory" class="accordion-collapse collapse show" aria-labelledby="headingHistory">
                    <div class="accordion-body text-center">
                        <img src="../assets/images/company-logo.jpg" alt="Baluzo Farm History" class="accordion-img">
                        <p class="mt-3">
                            Baluzo Farm (BF) was established in 2007 by Eduardo and Anicia Baluzo in Brgy. Pamorangon, Daet, Camarines Norte. 
                            What began as a small family farm for household food needs eventually grew into a community-centered organic farm.
                        </p>
                        <p>
                            In 2009, the couple attended seminars by the Department of Agriculture (DA) and adopted organic farming practices. 
                            They later formed the SEARCA - Brgy. Pamorangon Farmers Association, encouraging fellow farmers to practice sustainable farming 
                            and participate in agricultural programs.
                        </p>
                        <p>
                            Driven by a passion for healthy living, the Baluzo family has been actively teaching organic farming techniques 
                            and producing safe, natural food products for the community.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Vision -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingVision">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVision" aria-expanded="false" aria-controls="collapseVision">
                        Vision
                    </button>
                </h2>
                <div id="collapseVision" class="accordion-collapse collapse" aria-labelledby="headingVision">
                    <div class="accordion-body text-center">
                        
                        <p class="mt-3">
                            A farm that promotes a healthy community and environment through organic farming.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Mission -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingMission">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMission" aria-expanded="false" aria-controls="collapseMission">
                        Mission
                    </button>
                </h2>
                <div id="collapseMission" class="accordion-collapse collapse" aria-labelledby="headingMission">
                    <div class="accordion-body text-center">
                        
                        <ul class="mt-3 text-start d-inline-block">
                            <li>Educate individuals to appreciate and engage in farming.</li>
                            <li>Innovate and integrate modern organic farming technologies.</li>
                            <li>Build strong partnerships with private and government sectors for sustainable services.</li>
                            <li>Promote healthy living by ensuring access to organic food products.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Key Milestones -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingMilestones">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMilestones" aria-expanded="false" aria-controls="collapseMilestones">
                        Key Milestones
                    </button>
                </h2>
                <div id="collapseMilestones" class="accordion-collapse collapse" aria-labelledby="headingMilestones">
                    <div class="accordion-body text-center">
                        
                        <ul class="mt-3 text-start d-inline-block">
                            <li><b>2017</b> – Recognized as a Learning Site for Agriculture (LSA) by ATI-DA RO V.</li>
                            <li><b>2019</b> – Elevated to School for Practical Agriculture (SPA) by ATI Bicol.</li>
                            <li><b>2020</b> – Officially registered as BALUZO INTEGRATED FARM INSTITUTE INC. under the SEC.</li>
                            <li><b>2021</b> – Nominated for PHILGAP Certification by the DA Regional Office.</li>
                            <li><b>2023</b> – Achieved Certified Organic Farm status by OCCP for livestock, legumes, herbs, vegetables, and perennial crops.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Today -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingToday">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseToday" aria-expanded="false" aria-controls="collapseToday">
                        Today
                    </button>
                </h2>
                <div id="collapseToday" class="accordion-collapse collapse" aria-labelledby="headingToday">
                    <div class="accordion-body text-center">
                        
                        <p class="mt-3">
                            Baluzo Farm continues to be a model of organic farming in the Bicol Region, providing hands-on training, farm tours, 
                            and producing high-quality organic products. It serves as a learning hub for students, farmers, and organizations 
                            advocating for sustainable agriculture and healthy living.
                        </p>
                    </div>
                </div>
            </div>

        </div>

</section>





                <!-- Developers Section -->
                <section class="mt-4">
                    <h2 class="mb-3"><i class='bx bx-code-alt' ></i> Developers</h2>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <div class="col">
                            <div class="card h-100 shadow-sm text-center p-3">
                                <img src="../assets/images/developers/obias.jpg" alt="Obias, John Owen A." class="developer-img mx-auto">
                                <div class="card-body">
                                    <h4 class="card-title">Obias, John Owen A.</h4>
                                    <h5 class="card-text">Lead Developer</h5>
                                    <p>Web Development and Backend Integration</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm text-center p-3">
                                <img src="../assets/images/developers/avendano.jpg" alt="Avendaño, John Patrick B." class="developer-img mx-auto">
                                <div class="card-body">
                                    <h4 class="card-title">Avendaño, John Patrick B.</h4>
                                    <h5 class="card-text">Database & UI Specialist</h5>
                                    <p>Interface Design and User Experience</p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card h-100 shadow-sm text-center p-3">
                                <img src="../assets/images/developers/maigue.jpg" alt="Maigue, Merck San V." class="developer-img mx-auto">
                                <div class="card-body">
                                    <h4 class="card-title">Maigue, Merck San V.</h4>
                                    <h5 class="card-text">System Analyst</h5>
                                    <p>Thesis Documentation and Data Analysis</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

<!-- Institution Section -->
<section class="mt-5 text-center">
    <h2 class="mb-4"><i class='bx bxs-graduation'></i> Institution</h2>
    <div class="card shadow-sm mx-auto p-4" style="max-width: 600px; border-radius: 15px;">
        <img src="../assets/images/institution/aclc-logo.jpg" 
             alt="ACLC College of Daet" 
             class="mx-auto mb-3" 
             style="max-width: 140px; height: auto;">

        <h5 class="card-title">ACLC College of Daet</h5>
        <p class="mb-1">Bachelor of Science in Information Technology</p>
        <p class="text-muted">Class of 2025-2026</p>

        <hr>

        <p class="mb-1">
            <i class="bx bx-map"></i> 
            2F Guinahawa Bldg. J. Lukban St. Daet, Camarines Norte, Daet, Philippines
        </p>
        <p class="mb-1">
            <i class="bx bx-phone"></i> 
            0917 566 9532
        </p>
        <p>
            <a href="https://www.facebook.com/aclccollegeofdaet" 
               target="_blank" 
               class="btn btn-outline-dark btn-sm">
               <i class='bx bxl-facebook' ></i> ACLC College of Daet
            </a>
        </p>
    </div>
</section>


            </div>

        </main>

    </div>
<img src="../assets/images/lowerR-bg.png" alt="lowerR-bg" class="lowerR-bg">


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll('.accordion-collapse').forEach(collapse => {
    collapse.addEventListener('show.bs.collapse', () => {
        collapse.style.opacity = 0;
        setTimeout(() => collapse.style.opacity = 1, 50);
    });
    collapse.addEventListener('hide.bs.collapse', () => {
        collapse.style.opacity = 0;
    });
});
</script>


<script src="../assets/script/activeLink.js"></script>
<script src="../assets/script/navClicks.js"></script>
<script src="../assets/script/closeSidebar.js"></script>
<script src="../assets/script/toggleSidebar.js"></script>
<script src="../assets/script/preventCache.js"></script>

</body>
</html>
