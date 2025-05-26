<section id="access_dropdown">
    <section id="dropdown_preview" tabindex="0">
        <img src="./images/accessibility_icon.webp" alt="an image of a person with a disability icon">
    </section>
    <section id="dropdown_menu">
        <form method="get" action="./php/accessability.php">
            <button type="submit" name="accessibility" value="colour_scheme" class="accessibility_button" title="Turn on/off color blindness mode">
                <img src="./images/colour_blind.webp" alt="An image of a black and white droplet symbolizing color blindness">
            </button>

            <button type="submit" name="accessibility" value="text_size" class="accessibility_button" title="Increase/decrease text size | click to cycle through | <?php if ($_SESSION['accessibility']['text_size'] == 'default') { echo "Normal"; } else { echo ucfirst(substr($_SESSION['accessibility']['text_size'], 5)); } ?>">
                <img src="./images/<?php if ($_SESSION['accessibility']['text_size'] != 'default') { echo $_SESSION['accessibility']['text_size'] . ".webp"; } else {echo "font_medium.webp";} ?>" alt="An image of a large text symbolizing text size increase">
            </button>
        </form>
        
        <!-- this is a placeholder until functionality is made -->
        <img src="./images/accessibility_icon.webp" alt="an image of a person with a disability icon">
    </section>
</section>