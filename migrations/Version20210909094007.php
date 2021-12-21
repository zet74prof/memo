<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210909094007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD title VARCHAR(255) NOT NULL, ADD address VARCHAR(255) NOT NULL, ADD postal_code VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD birth_date DATE NOT NULL, ADD tel1 VARCHAR(255) DEFAULT NULL, ADD tel2 VARCHAR(255) DEFAULT NULL, ADD comment VARCHAR(3000) DEFAULT NULL, ADD email VARCHAR(360) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP title, DROP address, DROP postal_code, DROP city, DROP birth_date, DROP tel1, DROP tel2, DROP comment, DROP email');
    }
}
