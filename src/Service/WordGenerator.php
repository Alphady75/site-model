<?php

namespace App\Service;

use App\Entity\Fiche;
use App\Entity\Questionnaire;
use App\Entity\Statut;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class WordGenerator
{
    public function generateDeclaration(string $filePath, Fiche $fiche): string
    {
        $noms = strtoupper($fiche->getNom()) . ' ' . $fiche->getPrenom();
        $dateNaissance = $fiche->getDateNaissance()->format('d/m/Y');
        $dateLettre = $fiche->getDateLettre();
        $lieuNaissance = $fiche->getLieuNaissance();
        $nationalite = $fiche->getNationalite();
        $adresse = $fiche->getAdresse();
        $telephone = $fiche->getTelephone();
        $civilite = $fiche->getCivilite();
        $typepiece = $fiche->getTypePiece();
        $numpiece = $fiche->getNumPiece();
        $profession = $fiche->getProfession();
        $pieceDelivre = $fiche->getPieceDelivre()->format('d/m/Y');

        // Initialiser PHPWord
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Styles de texte
        $phpWord->addFontStyle('regular', ['size' => 10]);
        $phpWord->addFontStyle('bold', ['bold' => true, 'size' => 10]);
        $phpWord->addFontStyle('largeBold', ['bold' => true, 'size' => 16]); // Style pour texte en gros caractère et en gras

        // Ajout du texte avec style
        $section->addText('Téléphone :+221 ' . $telephone, 'regular', ['align' => 'both']);
        $section->addText('Dakar, le ' . $dateNaissance, 'regular', ['align' => 'right']);
        $section->addTextBreak(2);

        // Texte en gras et en gros caractère
        $section->addText('DECLARATION SUR L’HONNEUR', 'largeBold', ['align' => 'center']);
        $section->addTextBreak(2);

        $section->addText('A', 'bold', ['align' => 'center']);
        $section->addText('Madame le Greffier en chef du Registre du commerce', 'regular', ['align' => 'center']);
        $section->addTextBreak(2);

        // Texte principal
        $section->addText('Je soussignée,', 'regular', ['align' => 'both']);
        $section->addText($civilite . ' ' . $noms . ', ' . $profession . ', demeurant et domiciliée à ' . $adresse . ' ;', 'regular', ['align' => 'both']);
        $section->addText('Née à ' . $lieuNaissance . ' ('. $dateNaissance .'), le ' . $dateLettre . ' ;', 'regular', ['align' => 'both']);
        $section->addText('De nationalité ' . $nationalite . ' et titulaire de ' . $typepiece . ' n° '. $numpiece .', délivré le '. $pieceDelivre .'.', 'regular', ['align' => 'both']);
        $section->addTextBreak(1);

        // Liste avec tirets et justification
        $section->addText('ATTESTE SUR L’HONNEUR n’être frappée d’aucune des interdictions ci-après :', 'regular', ['align' => 'both']);
        $section->addText('- Interdiction générale, définitive ou temporaire, prononcée par une juridiction de l’un des Etats parties...', 'regular', ['align' => 'both']);
        $section->addText('- Interdiction prononcée par une juridiction professionnelle ;', 'regular', ['align' => 'both']);
        $section->addText('- Interdiction par l’effet d’une condamnation définitive à une peine privative de liberté...', 'regular', ['align' => 'both']);
        $section->addTextBreak(1);

        // Conclusion avec justification
        $section->addText('Je sais que cette déclaration pourra être produite en justice et que toute fausse déclaration de ma part, m’exposera à des sanctions pénales.', 'regular', ['align' => 'both']);
        $section->addTextBreak(1);
        $section->addText('Fait pour servir et valoir ce que de droit.', 'regular', ['align' => 'both']);
        $section->addText('Madame ' . $noms , 'regular', ['align' => 'right']);

        // Sauvegarder le fichier Word
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($filePath);

        return $filePath;
    }

    public function generateProcurationDocument(string $filePath, Fiche $fiche, Questionnaire $questionnaire, Statut $statut): void
    {
        $noms = strtoupper($fiche->getNom()) . ' ' . $fiche->getPrenom();
        $dateNaissance = $fiche->getDateNaissance()->format('d/m/Y');
        $dateLettre = $fiche->getDateLettre();
        $lieuNaissance = $fiche->getLieuNaissance();
        $nationalite = $fiche->getNationalite();
        $adresse = $fiche->getAdresse();
        $telephone = $fiche->getTelephone();
        $civilite = $fiche->getCivilite();
        $typepiece = $fiche->getTypePiece();
        $sitMat = $fiche->getSitMat();
        $numpiece = $fiche->getNumPiece();
        $datedeliver = $fiche->getPieceDelivre()->format('d/m/Y');
        $profession = $fiche->getProfession();
        $pieceDelivre = $fiche->getPieceDelivre()->format('d/m/Y');

        $gerant = $questionnaire->getGerantnom() . ' ' . $questionnaire->getGerantprenom();
        $regime = $fiche->getRegimeMat();

        $phpWord = new PhpWord();

        // Section du document
        $section = $phpWord->addSection();

        // Styles pour les paragraphes et les polices
        $phpWord->addFontStyle('regular', ['size' => 10]);
        $phpWord->addFontStyle('bold', ['bold' => true, 'size' => 10]);
        $phpWord->addFontStyle('largeBold', ['bold' => true, 'size' => 16]);
        $phpWord->addParagraphStyle('rightAlign', ['align' => 'right']);
        $phpWord->addParagraphStyle('justified', ['align' => 'both']);
        $phpWord->addParagraphStyle('center', ['align' => 'center']);
        $phpWord->addParagraphStyle('indent', ['indentation' => ['firstLine' => 720]]);

        // Titre en gros et gras, centré
        $section->addText('PROCURATION', 'largeBold', 'center');
        $section->addText('POUR LA CONSTITUTION DE LA SOCIETE', 'largeBold', 'center');
        $section->addText('« '. $questionnaire->getDenomination() .' » - '. $statut->getName() .'', 'largeBold', 'center');

        // Espacement
        $section->addTextBreak(2);

        // Ajout du texte principal avec style justifié
        $section->addText('La soussignée :', 'bold', 'justified');

        // Information de la mandante
        $section->addText($civilite . ' ' . $noms . ' , ' . $profession . ', demeurant et domiciliée à Dakar, (Sénégal),'. $adresse .'.. ;', 'regular', 'justified');
        $section->addText('Née à '. $lieuNaissance .', le '. $dateNaissance .' ;', 'regular', 'justified');
        $section->addText('De nationalité Sénégalaise et titulaire de la carte d’identité '. $typepiece .' n°'. $numpiece .', délivrée le 24 Octobre 2018.', 'regular', 'justified');
        $section->addText('Mariée sous le régime de la séparation de biens, ainsi qu’elle le déclare.', 'regular', 'justified');

        // Espacement
        $section->addTextBreak(1);

        // Mandataire
        $section->addText('Constitue par ces présentes, pour mandataire spécial avec droit de substitution général dans les limites de ce qui est permis par la loi, à la personne ci-après :', 'regular', 'justified');

        // Information de la mandataire
        $section->addText($civilite . ' ' . $noms . ' , '.$profession.', demeurant et domiciliée à Dakar, (Sénégal),'. $adresse .' ;', 'regular', 'justified');
        $section->addText('Née à '. $lieuNaissance .', le '. $dateLettre .' ;', 'regular', 'justified');
        $section->addText('De nationalité Sénégalaise et titulaire de la carte d’identité '. $typepiece .' n°'.$numpiece.', délivrée le '. $datedeliver .'.', 'regular', 'justified');
        $section->addText($sitMat . $regime ? ' ' . ' sous le régime de '. $regime .', ainsi qu’elle le déclare.' : '.', 'regular', 'justified');

        // Espacement
        $section->addTextBreak(1);

        // Détails de la société
        $section->addText('A qui il/elle donne pouvoirs d’agir en son nom à l’effet de constituer en signant notamment les statuts et tout document d’une société de droit Sénégalais dont les principales caractéristiques sont les suivantes :', 'regular', 'justified');
        $section->addText('Forme Juridique : ' . $statut->getName(), 'bold', 'justified');
        $section->addText('Gérante :  ' . $gerant ? $gerant : '……………………………………………………..', 'regular', 'justified');
        $section->addText('Dénomination : « '. $questionnaire->getDenomination() .' » - ' . $statut->getName(), 'regular', 'justified');
        $section->addText('Siège social : '. $questionnaire->getSiegesociale() .', ……………………………………………..', 'regular', 'justified');
        $section->addText('Capital social : Le capital social est fixé à la somme de ' . $questionnaire->getCapitalsocial() . ' Francs CFA divisé en Cent (100) parts sociales de Dix Mille Francs CFA (10.000 F CFA) chacune.', 'regular', 'justified');

        // Objet social
        $section->addText('Objet social : La société a pour objet tant au SENEGAL qu\'à l\'étranger et sous réserve de l\'obtention des autorisations nécessaires auprès des autorités compétentes, les activités suivantes :', 'bold', 'justified');
        $section->addText('- Le commerce et la vente de produits alimentaires ;', 'regular', 'justified');
        $section->addText('- L’Importation et l’exportation ;', 'regular', 'justified');
        $section->addText('- Le commerce général ;', 'regular', 'justified');
        $section->addText('- La distribution ;', 'regular', 'justified');
        $section->addText('- La représentation commerciale ;', 'regular', 'justified');
        $section->addText('- La prestation de Service ;', 'regular', 'justified');

        // Répartition des parts
        $section->addText('Répartition des parts :', 'bold', 'justified');
        $section->addText('Monsieur/Madame ……………………………………………..……………..………… 25% des parts sociales', 'regular', 'justified');
        $section->addText('Monsieur/Madame ………………………………………………………….…..………… 25% des parts sociales', 'regular', 'justified');
        $section->addText('Monsieur/Madame …………………..……………………………………………………. 25% des parts sociales', 'regular', 'justified');
        $section->addText('Monsieur/Madame …………………………….…………………………………………. 25% des parts sociales', 'regular', 'justified');

        // Souscription
        $section->addText('Souscription :', 'bold', 'justified');
        $section->addText('De souscrire à son nom dans le capital de la société en formation, à hauteur de Vingt Cinq (25) parts sociales de Dix Mille (10.000) Francs CFA.', 'regular', 'justified');

        // Date et signature
        $section->addText('Le 03 Juin 2024', 'regular', 'justified');
        $section->addText('LA MANDANTE', 'regular', 'justified');

        // Sauvegarde du fichier
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($filePath);
    }
}
