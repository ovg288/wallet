<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305154618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE balance_change_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE wallet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE balance_change (id BIGINT NOT NULL, wallet_id BIGINT DEFAULT NULL, amount NUMERIC(12, 2) NOT NULL, transaction_type VARCHAR(8) NOT NULL, change_reason VARCHAR(8) NOT NULL, currency VARCHAR(3) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_WALLET_ID ON balance_change (wallet_id)');
        $this->addSql('CREATE INDEX IDX_CHANGE_REASON_CREATED_AT ON balance_change (created_at, change_reason)');
        $this->addSql('COMMENT ON COLUMN balance_change.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE wallet (id BIGINT NOT NULL, user_id BIGINT NOT NULL, currency VARCHAR(3) NOT NULL, balance NUMERIC(12, 2) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE balance_change ADD CONSTRAINT FK_C5ACB849712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE balance_change_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE wallet_id_seq CASCADE');
        $this->addSql('ALTER TABLE balance_change DROP CONSTRAINT FK_C5ACB849712520F3');
        $this->addSql('DROP TABLE balance_change');
        $this->addSql('DROP TABLE wallet');
    }
}
