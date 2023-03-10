<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('users');

        $table->addColumn('name', 'string', ['null' => false])
            ->addColumn('email', 'string', ['null' => false,])
            ->addColumn('password', 'string', ['null' => false])
            ->addColumn('avatar', 'string', ['default' => '../frontend/assets/images/avatar.png'])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('phone', 'string', ['null' => true])
            ->addColumn('social_links', 'text', ['null' => true])
            ->addColumn('role_id', 'integer', ['null' => true, 'signed' => false, 'default' => 4])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['email'],['unique' => true])
            ->addForeignKey('role_id', 'roles', 'id', ['delete' => 'SET_NULL'])
            ->save();
    }
}
