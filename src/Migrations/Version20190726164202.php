<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190726164202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

      //  $this->addSql('ALTER TABLE passer DROP PRIMARY KEY');
      //  $this->addSql('ALTER TABLE passer DROP note');
      //  $this->addSql('ALTER TABLE passer ADD PRIMARY KEY (id_eleve, idControle)');
      //  $this->addSql('ALTER TABLE passer RENAME INDEX fk_eleve_passer TO IDX_970EA41622444C7');
        $this->addSql('ALTER TABLE enseignant ADD classe_id INT NOT NULL');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA18F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
      //  $this->addSql('CREATE UNIQUE INDEX UNIQ_81A72FA18F5EA509 ON enseignant (classe_id)');
      //  $this->addSql('ALTER TABLE note CHANGE eleve_id eleve_id INT DEFAULT NULL');
      //  $this->addSql('ALTER TABLE notes_eleve CHANGE eleve_id eleve_id INT DEFAULT NULL, CHANGE controle_id controle_id INT DEFAULT NULL');
      //  $this->addSql('ALTER TABLE participer DROP PRIMARY KEY');
      //  $this->addSql('ALTER TABLE participer ADD PRIMARY KEY (jour, heure, idMatiere, idEleve)');
      //  $this->addSql('ALTER TABLE seance CHANGE matiere_id matiere_id INT DEFAULT NULL, CHANGE classe_id classe_id INT DEFAULT NULL');
      //  $this->addSql('ALTER TABLE users CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

      //  $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA18F5EA509');
      //  $this->addSql('DROP INDEX UNIQ_81A72FA18F5EA509 ON enseignant');
      //  $this->addSql('ALTER TABLE enseignant DROP classe_id');
      //  $this->addSql('ALTER TABLE note CHANGE eleve_id eleve_id INT NOT NULL');
      //  $this->addSql('ALTER TABLE notes_eleve CHANGE controle_id controle_id INT NOT NULL, CHANGE eleve_id eleve_id INT NOT NULL');
      //  $this->addSql('ALTER TABLE participer DROP PRIMARY KEY');
      //  $this->addSql('ALTER TABLE participer ADD PRIMARY KEY (idMatiere, jour, heure, idEleve)');
      //  $this->addSql('ALTER TABLE passer DROP PRIMARY KEY');
      //  $this->addSql('ALTER TABLE passer ADD note INT DEFAULT NULL');
      //  $this->addSql('ALTER TABLE passer ADD PRIMARY KEY (idControle, id_eleve)');
      //  $this->addSql('ALTER TABLE passer RENAME INDEX idx_970ea41622444c7 TO fk_eleve_passer');
      //  $this->addSql('ALTER TABLE seance CHANGE classe_id classe_id INT NOT NULL, CHANGE matiere_id matiere_id INT NOT NULL');
      //  $this->addSql('ALTER TABLE users CHANGE id id INT NOT NULL');
    }
}
