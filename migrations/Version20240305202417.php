<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305202417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE exchange_rate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE exchange_rate (id BIGINT NOT NULL, base_currency VARCHAR(3) NOT NULL, counter_currency VARCHAR(3) NOT NULL, rate NUMERIC(12, 2) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E9521FAB8B8E842823BD2BC725B1F33D ON exchange_rate (created_at, base_currency, counter_currency)');
        $this->addSql('COMMENT ON COLUMN exchange_rate.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE exchange_rate_id_seq CASCADE');
        $this->addSql('DROP TABLE exchange_rate');
    }
}
