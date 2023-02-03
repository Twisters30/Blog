<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePosts extends AbstractMigration
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
        $table = $this->table('posts');

        $table->addColumn('name', 'string', ['null' => false])
            ->addColumn('description', 'text', ['null' => false])
            ->addColumn('image', 'string',  ['null' => false])
            ->addColumn('icon', 'string',  ['null' => false])
            ->addColumn('user_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'SET_NULL'])
            ->save();
    }
}
