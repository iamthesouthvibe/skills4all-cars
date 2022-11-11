<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221110153027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD car_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D78C4629E FOREIGN KEY (car_category_id) REFERENCES car_category (id)');
        $this->addSql('CREATE INDEX IDX_773DE69D78C4629E ON car (car_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D78C4629E');
        $this->addSql('DROP INDEX IDX_773DE69D78C4629E ON car');
        $this->addSql('ALTER TABLE car DROP car_category_id');
    }
}
