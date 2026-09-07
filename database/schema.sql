-- Schema de la base de donnees Ouagadougou Tourisme
-- PostgreSQL

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des sites patrimoniaux
CREATE TABLE IF NOT EXISTS sites (
    id SERIAL PRIMARY KEY,
    nom_site VARCHAR(200) NOT NULL,
    image_path VARCHAR(255),
    description TEXT,
    historique TEXT,
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des images supplementaires des sites
CREATE TABLE IF NOT EXISTS images_sites (
    id SERIAL PRIMARY KEY,
    site_id INTEGER REFERENCES sites(id) ON DELETE CASCADE,
    image_path VARCHAR(255) NOT NULL
);

-- Table des hotels
CREATE TABLE IF NOT EXISTS hotels (
    id SERIAL PRIMARY KEY,
    nom_hotel VARCHAR(200) NOT NULL,
    adresse VARCHAR(300),
    description TEXT,
    image_path VARCHAR(255),
    etoiles INTEGER DEFAULT 3,
    prix_moyen DECIMAL(10,2),
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des reservations
CREATE TABLE IF NOT EXISTS reservations (
    id SERIAL PRIMARY KEY,
    utilisateur_id INTEGER REFERENCES utilisateurs(id) ON DELETE CASCADE,
    hotel_id INTEGER REFERENCES hotels(id) ON DELETE CASCADE,
    date_arrivee DATE NOT NULL,
    date_depart DATE NOT NULL,
    nb_personnes INTEGER NOT NULL DEFAULT 1,
    statut VARCHAR(50) DEFAULT 'confirmee',
    date_reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index pour ameliorer les performances
CREATE INDEX IF NOT EXISTS idx_reservations_utilisateur ON reservations(utilisateur_id);
CREATE INDEX IF NOT EXISTS idx_reservations_hotel ON reservations(hotel_id);
CREATE INDEX IF NOT EXISTS idx_images_sites_site ON images_sites(site_id);

-- =====================================================
-- DONNEES DE DEMONSTRATION
-- =====================================================

-- Insertion des sites patrimoniaux de Ouagadougou
INSERT INTO sites (nom_site, image_path, description, historique) VALUES
('Place des Nations Unies', 'pdc.jpg',
 'La Place des Nations Unies est le coeur de Ouagadougou, un lieu de rassemblement majeur pour les evenements nationaux et internationaux. Elle symbolise l''unite et l''ouverture du Burkina Faso sur le monde.',
 'Inauguree dans les annees 1960, cette place a ete le temoin de nombreux moments historiques du Burkina Faso, notamment des discours du President Thomas Sankara.'),

('Musee National du Burkina', 'musee1.jpg',
 'Le Musee National abrite une riche collection d''objets d''art et d''artisanat traditionnels burkinabe, temoignant de la diversite culturelle des 60 ethnies du pays.',
 'Cree en 1962, le musee a ete reorganise plusieurs fois pour mieux presenter le patrimoine culturel national. Il accueille plus de 50 000 visiteurs par an.'),

('Monument des Heros Nationaux', 'mhn1.jpg',
 'Ce monument rend hommage aux heros de l''independance et aux personnalites qui ont marque l''histoire du Burkina Faso, dont Thomas Sankara.',
 'Erige en 2010, le monument est devenu un lieu de memoire et de recueillement pour les Burkinabe et les visiteurs.'),

('Parc Bangr-Weogo', 'pbw1.jpg',
 'Veritable poumon vert au coeur de Ouagadougou, le Parc Bangr-Weogo (foret du savoir) est un espace naturel preserve de 265 hectares abritant une faune et une flore diversifiees.',
 'Autrefois foret sacree des Mossi, ce parc a ete amenage dans les annees 1930 et classe reserve naturelle. Il abrite des crocodiles, des singes et de nombreuses especes d''oiseaux.'),

('Cathedrale de l''Immaculee Conception', 'monument-ouaga.jpg',
 'La Cathedrale de Ouagadougou est un edifice religieux majeur, melant architecture coloniale et elements traditionnels africains.',
 'Construite en 1934, elle est le siege de l''archidiocese de Ouagadougou et peut accueillir plus de 1500 fideles.'),

('Le FASO Parc', 'Le-Faso-Parc.jpg',
 'Parc d''attractions et de loisirs familial, le FASO Parc offre des activites recreatives pour petits et grands dans un cadre agreable.',
 'Ouvert en 2005, ce parc moderne contribue au developpement des loisirs et du tourisme local.');

-- Insertion des images supplementaires (utiliser des images existantes)
INSERT INTO images_sites (site_id, image_path) VALUES
(1, 'pdc3.jpg'),
(2, 'musee2.jpg'),
(2, 'musee3.jpg'),
(3, 'heros1.jpg'),
(3, 'heros2.jpg'),
(4, 'pbw2.jpg'),
(4, 'bangrweoogo.jpg');

-- Insertion des hotels partenaires (avec images existantes)
INSERT INTO hotels (nom_hotel, adresse, description, image_path, etoiles, prix_moyen) VALUES
('Hotel Splendid', 'Avenue Kwame Nkrumah, Ouagadougou',
 'Hotel 4 etoiles au coeur de la capitale, offrant confort moderne et service impeccable. Piscine, restaurant gastronomique et centre de conferences.',
 'splendid.jpg', 4, 85000),

('Laico Hotel Ouagadougou', 'Boulevard Charles de Gaulle, Ouagadougou',
 'Le plus grand hotel de Ouagadougou avec 150 chambres. Vue panoramique sur la ville, spa et salle de sport.',
 'laico.jpg', 5, 120000),

('Hotel Palm Beach', 'Zone du Bois, Ouagadougou',
 'Hotel familial avec jardin tropical et piscine. Ideal pour les sejours en famille. Restaurant avec cuisine locale et internationale.',
 'palm.jpg', 3, 45000),

('Hotel Silmande', 'Secteur 4, Ouagadougou',
 'Appartements equipes pour longs sejours. Cuisine, salon et chambre separee. Proche du centre-ville.',
 'silmande.jpg', 3, 35000),

('Hotel Azalai', 'Avenue de l''Independance, Ouagadougou',
 'Hotel boutique moderne avec design contemporain africain. Rooftop bar avec vue sur la ville.',
 'azalai.jpg', 4, 75000),

('Bravia Hotel', 'Ouaga 2000, Ouagadougou',
 'Hotel d''affaires dans le quartier moderne de Ouaga 2000. Salles de reunion, wifi haut debit et navette aeroport.',
 'bravia.jpg', 4, 90000);

-- Creer un utilisateur admin de demonstration (mot de passe: admin123)
INSERT INTO utilisateurs (nom, email, mot_de_passe, telephone) VALUES
('Admin Demo', 'admin@ouaga-tourisme.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+226 70 00 00 00');
