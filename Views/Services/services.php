<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Services</title>
    <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/home.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/tests_offered.css">
    <script src="Views/Shared/Scripts/addRemoveInputs.js" defer></script>
    <script src="Views/Shared/Scripts/toggleGender.js" defer></script>
    <script src="Views/Shared/Scripts/searchDropdown.js" defer></script>
    <script src="Views/Home/orderTest.js" defer></script>
</head>
<body>
<?php
include_once 'Views/Shared/navbar.php';
?>

    <div class="padding"> <!-- TODO: ADD PADDING-->
        <h2>Our Service</h2>
        <p>We offer genotyping services for ball python morph mutations that we have discovered. Every test costs $50 + tax. Sheds coming from out of the country require a CITES permit. To order tests, please go <a href="index.php?action=test&controller=order_test">here</a>.</p>

        <h2>Different Tests Offered</h2>
        <center>
            <div id="tests_offered">
                <table>
                    <div class="tableCategory">
                        <!-- IMAGE ROW 1 -->
                        <tr>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Albino</h4>
                            </td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Candy/Toffee</h4>
                            </td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Clown</h4>
                            </td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Cryptic</h4>
                            </td>
                        </tr>
                        <!-- IMAGE ROW 2 -->
                        <tr>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Desert/ghost/enhancer</h4>
                            </td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Hypo/Ghost</h4>
                            </td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Lavander Albino</h4>
                            </td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Piebald</h4>
                            </td>
                        </tr>

                        <!-- IMAGE ROW 3 -->
                        <tr>
                            <td></td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Ultramel</h4>
                            </td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>VPI Anxanthic</h4>
                            </td>
                            <td></td>
                        </tr>
                    </div>
                    
                    <div class="tableCategory">
                        <tr>
                            <th colspan="4">Yellowbelly Complex</td>
                        </tr>
                        <!-- IMAGE ROW 4 -->
                        <tr id="triple">
                            <td></td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Asphalt</h4>
                            </td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Gravel</h4>
                            </td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Spark</h4>
                            </td>
                            <td></td>
                        </tr>
                        <!-- IMAGE ROW 5 -->
                        <tr>
                            <td></td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Specter</h4>
                            </td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Yellowbelly</h4>
                            </td>
                            <td></td>
                        </tr>
                    </div>
                    
                    <div class="tableCategory">
                        <tr>
                            <th colspan="4">8-Ball Complex</td>
                        </tr>
                        <!-- IMAGE ROW 6 -->
                        <tr>
                            <td></td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Black Pastel</h4>
                            </td>
                            <td>
                                <img src="Views/Images/snake_dummy_image.jpeg" alt="snake">
                                <h4>Enchi</h4>
                            </td>
                            <td></td>
                        </tr>
                    </div>
                </table>
            </div>
        </center>
        </br></br>
        <h2>Donations</h2>
        <p>All the mutations for which we can test are listed above. To gain the ability to test more mutations, we need to discover more mutations. To discover mutations, we need snake sheds.</p>
        <p>Sheds from homozygous individuals are best (i.e., visuals from recessives, supers from incomplete dominants). For the rarer morphs, we welcome known hets (i.e., from a visual parent, proven through breeding, identified through genotyping).</p>
        <p>To donate snake sheds, go <a href="index.php?action=donation&controller=donation">here</a>.</p>

        <h2>Folding envelopes for donations or tests</h2>
        <p>To submit snake sheds for donations or tests, you need to fold and send me an envelope that contains your snake shed.</p>
        <ol>
            <li>Shed submission envelope: Print (double-sided is best), cut, and fold envelope according to instructions on the pdf.</li>
            <li>
                Collect a small portion of your snake's shed (Loonie size)
                <ul>
                    <li>Dorsal (back) region is preferred due to small size of scales.</li>
                    <li>Shed should be dry and clean (e.g., no feces, urates, bedding). If necessary, wash and dry the desired section. The acidity of coco and urates may cause erroneos results or inconveniences in my testing. This makes me sad because I will have to redo everything again, often with the same result. It makes you sad because you are waiting longer for results now that you have been asked to send in another shed.</li>
                </ul>
            </li>
            <li>Staple shed to the envelope over the designated square. I will tear off what I need for genotyping.
            </br>Fold the envelope closed and store until submission. It is not necessary to staple the envelope closed if the shed is covered by the flaps. If you must staple, a single staple at the bottom will suffice.
            </br>Sheds can be stored at room temperature or in the freezer prior to mailing them. Protect them from direct sunlight, high humidity, and high temperatures.
            </li>
            <li>
                Mail sheds to me at 
                </br> Heather Roffey
                </br> Vanier College - Biology Department
                </br> 821 Sainte-Croix Ave
                </br> Saint-Laurent, QC H4L 3X9
                </br> 
                </br> Results will be communicated to you within 2-6 weeks after payment and snake sheds have been recieved. 
            </li>
        </ol>

        <h2>Video tutorial for folding the snake shed envelope</h2>
        <center>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/BurN-o23KKM?si=XymkZl6LUXAEcW3G" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </center>
    </div>
</body>
</html>