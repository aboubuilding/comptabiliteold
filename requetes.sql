-- requetes pour gerer les liste de la cantine

select i.id,  e.nom , e.prenom , n.libelle as niveau_eleve, c.libelle as cycle, d.frais_ecole_id, i.frais_cantine,
p.nom_parent, p.prenom_parent, p.email, MIN(d.created_at),

 SUM(d.montant)

from details d

join inscriptions i on i.id = d.inscription_id
join eleves e on e.id = i.eleve_id
join niveaux n on n.id = i.niveau_id
join cycles c on c.id = i.cycle_id
LEFT JOIN  espaces es on es.id = i.espace_id
LEFT JOIN parent_eleves p on p.espace_id = es.id


where d.etat = 1
and d.type_paiement = 8
and d.statut_paiement = 2
and p.is_principal = 1

group by i.id,  e.nom , e.prenom,  n.libelle, c.libelle



;
----- requete pour supprimer la colonne photo de la table voiture
ALTER TABLE voitures
DROP COLUMN photo;

----- requete pour supprimer la colonne couleur  de la table voiture
ALTER TABLE voitures
DROP COLUMN couleur;


----- requete pour supprimer la colonne categorie_permis  de la table chauffeurs
ALTER TABLE chauffeurs
DROP COLUMN categorie_permis;


----- requete pour supprimer la colonne categorie_permis  de la table chauffeurs
ALTER TABLE chauffeurs
DROP COLUMN voiture_id;



----- requete pour supprimer la colonne voiture_id  de la table lignes
ALTER TABLE lignes
DROP COLUMN voiture_id;


----- requete pour supprimer la colonne chauffeur_id  de la table lignes
ALTER TABLE lignes
DROP COLUMN chauffeur_id;

----------- requete pour obtenir la liste des eleves n ayant pas encore payé
select e.nom, i.id,  e.nom , e.prenom , n.libelle as niveau_eleve, p.email

from inscriptions i

join eleves e on e.id = i.eleve_id
join niveaux n on n.id = i.niveau_id
left join parent_eleves p on p.id = i.parent_id


where i.etat = 1
and i.statut_validation = 2
and i.id not in (select distinct d.inscription_id

from details d  )

----------- requete pour ajouter la  colonne  frais examen
ALTER TABLE `inscriptions` ADD `frais_examen` FLOAT NULL AFTER `frais_livre`;

----------- afficher les paiements par eleve 

select i.id,  e.nom , e.prenom , n.libelle as niveau_eleve, c.libelle AS cycle_libelle, de.montant, f.montant as scolarite 

from inscriptions i




join eleves e on e.id = i.eleve_id
left join (

select i.id,  SUM(d.montant) as montant

from details d

join inscriptions i on i.id = d.inscription_id


where d.etat = 1
and d.type_paiement = 2
and d.statut_paiement = 2

group by i.id



) de  on de.id = i.id
join niveaux n on n.id = i.niveau_id
join cycles c on c.id = i.cycle_id
left join frais_ecoles f on f.niveau_id = n.id


where i.etat = 1


and i.statut_validation = 2

group by i.id,  e.nom , e.prenom,  n.libelle

ORDER BY e.nom;


----------------------------------- requestes pour les activites extrascolaire 

select i.id,  e.nom , e.prenom , n.libelle as niveau_eleve, c.libelle as cycle, d.frais_ecole_id, f.libelle, d.created_at, SUM(d.montant)

from details d

join inscriptions i on i.id = d.inscription_id
join eleves e on e.id = i.eleve_id
join niveaux n on n.id = i.niveau_id
join cycles c on c.id = i.cycle_id
join frais_ecoles f on d.frais_ecole_id = f.id

where d.frais_ecole_id BETWEEN 76 and 90 and d.etat = 1

and d.statut_paiement = 2

group by i.id,  e.nom , e.prenom,  n.libelle, c.libelle, d.frais_ecole_id;
