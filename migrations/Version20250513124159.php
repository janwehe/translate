<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250513124159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE language (
              id INT AUTO_INCREMENT NOT NULL,
              iso_code VARCHAR(8) NOT NULL,
              name VARCHAR(255) NOT NULL,
              created DATETIME NOT NULL,
              updated DATETIME DEFAULT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE origin (
              id INT AUTO_INCREMENT NOT NULL,
              language_id INT NOT NULL,
              txt LONGTEXT NOT NULL,
              created DATETIME NOT NULL,
              updated DATETIME DEFAULT NULL,
              INDEX IDX_DEF1561E82F1BAF4 (language_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE translation (
              id INT AUTO_INCREMENT NOT NULL,
              language_id INT NOT NULL,
              origin_id INT NOT NULL,
              txt LONGTEXT NOT NULL,
              created DATETIME NOT NULL,
              updated DATETIME DEFAULT NULL,
              INDEX IDX_B469456F82F1BAF4 (language_id),
              INDEX IDX_B469456F56A273CC (origin_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              origin
            ADD
              CONSTRAINT FK_DEF1561E82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              translation
            ADD
              CONSTRAINT FK_B469456F82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              translation
            ADD
              CONSTRAINT FK_B469456F56A273CC FOREIGN KEY (origin_id) REFERENCES origin (id)
        SQL);

        // initial data manually added
        $this->addSql(<<<'SQL'
            INSERT INTO `language` (`id`, `iso_code`, `name`, `created`, `updated`) VALUES
                (1, 'DE', 'Deutsch', '2025-05-13 12:45:13', NULL),
                (2, 'EN-GB', 'Englisch (Britisch)', '2025-05-13 12:45:13', NULL),
                (3, 'EN-US', 'Englisch (Amerikanisch)', '2025-05-13 12:46:27', NULL),
                (4, 'FR', 'Französisch', '2025-05-13 12:46:27', NULL),
                (5, 'ES', 'Spanisch', '2025-05-13 12:46:55', NULL),
                (6, 'IT', 'Italienisch', '2025-05-13 12:46:56', NULL);
        SQL);

        $this->addSql(<<<'SQL'
            INSERT INTO `origin` (`id`, `language_id`, `txt`, `created`, `updated`) VALUES
                (1, 1, 'Die Würde des Menschen ist unantastbar. Sie zu achten und zu schützen ist Verpflichtung aller staatlichen Gewalt.', '2025-05-13 12:48:39', NULL),
                (2, 1, 'Jeder hat das Recht auf die freie Entfaltung seiner Persönlichkeit, soweit er nicht die Rechte anderer verletzt und nicht gegen die verfassungsmäßige Ordnung oder das Sittengesetz verstößt.', '2025-05-13 12:48:39', NULL),
                (3, 1, 'Alle Menschen sind vor dem Gesetz gleich.', '2025-05-13 12:49:22', NULL),
                (4, 1, 'Jeder hat das Recht, seine Meinung in Wort, Schrift und Bild frei zu äußern und zu verbreiten und sich aus allgemein zugänglichen Quellen ungehindert zu unterrichten. Die Pressefreiheit und die Freiheit der Berichterstattung durch Rundfunk und Film werden gewährleistet. Eine Zensur findet nicht statt.', '2025-05-13 12:49:22', NULL);
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE origin DROP FOREIGN KEY FK_DEF1561E82F1BAF4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE translation DROP FOREIGN KEY FK_B469456F82F1BAF4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE translation DROP FOREIGN KEY FK_B469456F56A273CC
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE language
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE origin
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE translation
        SQL);
    }
}
