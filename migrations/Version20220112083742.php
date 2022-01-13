<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112083742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE benevole (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE type_formation ADD benevole_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_formation ADD CONSTRAINT FK_F48660AFE77B7C09 FOREIGN KEY (benevole_id) REFERENCES benevole (id)');
        $this->addSql('CREATE INDEX IDX_F48660AFE77B7C09 ON type_formation (benevole_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type_formation DROP FOREIGN KEY FK_F48660AFE77B7C09');
        $this->addSql('DROP TABLE benevole');
        $this->addSql('DROP INDEX IDX_F48660AFE77B7C09 ON type_formation');
        $this->addSql('ALTER TABLE type_formation DROP benevole_id');
    }
}
