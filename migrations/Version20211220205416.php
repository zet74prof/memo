<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211220205416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apprenant (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, tel1 VARCHAR(255) DEFAULT NULL, tel2 VARCHAR(255) DEFAULT NULL, comment VARCHAR(3000) DEFAULT NULL, email VARCHAR(360) DEFAULT NULL, enfant_acharge INT DEFAULT NULL, UNIQUE INDEX UNIQ_C4EB462EF85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, site_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_histo (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, site_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_2DFDB52FA76ED395 (user_id), INDEX IDX_2DFDB52FF6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state_histo (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, date DATE NOT NULL, active TINYINT(1) NOT NULL, reason VARCHAR(255) DEFAULT NULL, INDEX IDX_9B34E126A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, status_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE site_histo ADD CONSTRAINT FK_2DFDB52FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE site_histo ADD CONSTRAINT FK_2DFDB52FF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE state_histo ADD CONSTRAINT FK_9B34E126A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE site_histo DROP FOREIGN KEY FK_2DFDB52FF6BD1646');
        $this->addSql('DROP TABLE apprenant');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE site_histo');
        $this->addSql('DROP TABLE state_histo');
        $this->addSql('DROP TABLE status');
    }
}
