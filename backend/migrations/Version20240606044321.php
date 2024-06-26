<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240606044321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE news_site_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parsed_news_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE news_site (id INT NOT NULL, url VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE parsed_news (id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, news_url VARCHAR(255) NOT NULL, news_main_picture VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, source_name VARCHAR(255) NOT NULL, content VARCHAR(1000) NOT NULL, rating INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN parsed_news.date IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE news_site_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parsed_news_id_seq CASCADE');
        $this->addSql('DROP TABLE news_site');
        $this->addSql('DROP TABLE parsed_news');
    }
}
