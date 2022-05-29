<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529184110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE refresh_token ALTER valid TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE refresh_token ALTER valid DROP DEFAULT');
        $this->addSql('ALTER TABLE refresh_token ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE refresh_token ALTER created_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN refresh_token.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE refresh_token ALTER valid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE refresh_token ALTER valid DROP DEFAULT');
        $this->addSql('ALTER TABLE refresh_token ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE refresh_token ALTER created_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN refresh_token.created_at IS NULL');
    }
}
