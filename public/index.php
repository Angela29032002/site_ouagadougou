<?php
// Affichage des erreurs pour débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/header.php';
?>

<section>
  <h2>Bienvenue à Ouagadougou</h2>
  <p style="margin-top: 10px;">
    Capitale du Burkina Faso, Ouagadougou est une ville dynamique au riche patrimoine culturel et historique.
    Elle abrite des monuments emblématiques, des espaces naturels préservés, ainsi qu’une vie artisanale foisonnante.
  </p>

  <p style="margin-top: 15px;">
    Explorez les merveilles touristiques de la ville, admirez ses sites, découvrez ses trésors artisanaux et réservez un hébergement directement depuis ce portail.
  </p>

  <!-- Zone d'affichage des images -->
  <div class="slideshow-container">
    <img id="slideshow" src="images/pbw1.jpg" alt="Slideshow Ouaga" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; margin-top: 20px;">
  </div>

  <script>
    // ✅ Liste des images avec virgules correctement placées
    const images = [
      "images/pbw1.jpg",
      "images/pbw2.jpg",
      //"images/photo0jpg.jpg",
      "images/pdc.jpg",
      "images/pdc1.jpg",
      "images/musee1.jpg",
      "images/musee2.jpg",
      "images/mhn1.jpg",
      "images/mhn2.jpg",
      "images/monument-ouaga.jpg",
      "images/Le-Faso-Parc.jpg"
    ];

    const slideshow = document.getElementById("slideshow");
    let lastIndex = -1;

    function getRandomIndex(excludeIndex) {
      let index;
      do {
        index = Math.floor(Math.random() * images.length);
      } while (index === excludeIndex);
      return index;
    }

    function changeImage() {
      slideshow.classList.remove("visible");

      setTimeout(() => {
        const newIndex = getRandomIndex(lastIndex);
        slideshow.src = images[newIndex];
        lastIndex = newIndex;
        slideshow.classList.add("visible");

        // Optional debug:
        // console.log("Nouvelle image :", images[newIndex]);
      }, 500);
    }

    window.onload = () => {
      lastIndex = Math.floor(Math.random() * images.length);
      slideshow.src = images[lastIndex];
      slideshow.classList.add("visible");
    };

    setInterval(changeImage, 3000);
  </script>
</section>

<?php include 'includes/footer.php'; ?>
