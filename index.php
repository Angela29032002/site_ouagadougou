<?php
include 'includes/header.php';
?>

<section>
  <h2>Bienvenue a Ouagadougou</h2>

  <p style="text-align: center; max-width: 800px; margin: 0 auto 20px;">
    Capitale du Burkina Faso, Ouagadougou est une ville dynamique au riche patrimoine culturel et historique.
    Elle abrite des monuments emblematiques, des espaces naturels preserves, ainsi qu'une vie artisanale foisonnante.
  </p>

  <p style="text-align: center; max-width: 800px; margin: 0 auto;">
    Explorez les merveilles touristiques de la ville, admirez ses sites, decouvrez ses tresors artisanaux
    et reservez un hebergement directement depuis ce portail.
  </p>

  <div class="slideshow-container">
    <img id="slideshow" src="images/pbw1.jpg" alt="Slideshow Ouagadougou">
  </div>

  <div class="site-grid" style="margin-top: 50px;">
    <div class="site-card">
      <img src="images/musee1.jpg" alt="Patrimoine">
      <h3>Patrimoine Culturel</h3>
      <p>Decouvrez les sites historiques et monuments qui font la fierte du Burkina Faso.</p>
      <a href="patrimoine.php" class="button">Explorer</a>
    </div>

    <div class="site-card">
      <img src="images/laico.jpg" alt="Hotels">
      <h3>Hotels & Hebergements</h3>
      <p>Trouvez l'hotel ideal pour votre sejour a Ouagadougou parmi notre selection.</p>
      <a href="<?= isset($_SESSION['utilisateur']) ? 'hotels.php' : 'login.php' ?>" class="button">Reserver</a>
    </div>

    <div class="site-card">
      <img src="images/artisanat.jpg" alt="Galerie">
      <h3>Galerie Photos</h3>
      <p>Admirez les plus belles images de Ouagadougou et de ses environs.</p>
      <a href="galerie.php" class="button">Voir</a>
    </div>
  </div>

  <script>
    const images = [
      "images/pbw1.jpg",
      "images/pbw2.jpg",
      "images/pdc.jpg",
      "images/musee1.jpg",
      "images/musee2.jpg",
      "images/mhn1.jpg",
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
      }, 500);
    }

    window.onload = () => {
      lastIndex = Math.floor(Math.random() * images.length);
      slideshow.src = images[lastIndex];
      slideshow.classList.add("visible");
    };

    setInterval(changeImage, 4000);
  </script>
</section>

<?php include 'includes/footer.php'; ?>
