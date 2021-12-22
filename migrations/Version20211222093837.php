<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222093837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE niv_form_histo (id INT AUTO_INCREMENT NOT NULL, niveau_formation_id INT NOT NULL, apprenant_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_B6C0D7B1288FF3B4 (niveau_formation_id), INDEX IDX_B6C0D7B1C5697D6D (apprenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_formation (id INT AUTO_INCREMENT NOT NULL, niv_form_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prescripteur (id INT AUTO_INCREMENT NOT NULL, prescripteur_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qpv (id INT AUTO_INCREMENT NOT NULL, qpv_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_formation (id INT AUTO_INCREMENT NOT NULL, formation_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE niv_form_histo ADD CONSTRAINT FK_B6C0D7B1288FF3B4 FOREIGN KEY (niveau_formation_id) REFERENCES niveau_formation (id)');
        $this->addSql('ALTER TABLE niv_form_histo ADD CONSTRAINT FK_B6C0D7B1C5697D6D FOREIGN KEY (apprenant_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user ADD type_formation_id INT NOT NULL, ADD prescripteur_id INT NOT NULL, ADD qpv_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D543922B FOREIGN KEY (type_formation_id) REFERENCES type_formation (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D486E642 FOREIGN KEY (prescripteur_id) REFERENCES prescripteur (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495F3A7C6A FOREIGN KEY (qpv_id) REFERENCES qpv (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D543922B ON user (type_formation_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D486E642 ON user (prescripteur_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495F3A7C6A ON user (qpv_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE niv_form_histo DROP FOREIGN KEY FK_B6C0D7B1288FF3B4');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649D486E642');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6495F3A7C6A');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649D543922B');
        $this->addSql('DROP TABLE niv_form_histo');
        $this->addSql('DROP TABLE niveau_formation');
        $this->addSql('DROP TABLE prescripteur');
        $this->addSql('DROP TABLE qpv');
        $this->addSql('DROP TABLE type_formation');
        $this->addSql('DROP INDEX IDX_8D93D649D543922B ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D649D486E642 ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D6495F3A7C6A ON `user`');
        $this->addSql('ALTER TABLE `user` DROP type_formation_id, DROP prescripteur_id, DROP qpv_id');
    }
}
