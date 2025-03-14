<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250312135424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_candidacy DROP FOREIGN KEY FK_D9D0DB79A76ED395');
        $this->addSql('ALTER TABLE user_candidacy DROP FOREIGN KEY FK_D9D0DB7959B22434');
        $this->addSql('DROP TABLE user_candidacy');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_candidacy (user_id INT NOT NULL, candidacy_id INT NOT NULL, INDEX IDX_D9D0DB79A76ED395 (user_id), INDEX IDX_D9D0DB7959B22434 (candidacy_id), PRIMARY KEY(user_id, candidacy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_candidacy ADD CONSTRAINT FK_D9D0DB79A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_candidacy ADD CONSTRAINT FK_D9D0DB7959B22434 FOREIGN KEY (candidacy_id) REFERENCES candidacy (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
