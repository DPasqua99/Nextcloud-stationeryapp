<?php

  namespace OCA\stationeryapp\Migration;

  use Closure;
  use OCP\DB\ISchemaWrapper;
  use OCP\Migration\SimpleMigrationStep;
  use OCP\Migration\IOutput;

  class Version000000Date20211107100331 extends SimpleMigrationStep {

    /**
    * @param IOutput $output
    * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
    * @param array $options
    * @return null|ISchemaWrapper
    */
    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if (!$schema->hasTable('action')) {
            $table = $schema->createTable('action');
            $table->addColumn('id', 'integer', [
                'autoincrement' => true,
                'notnull' => true,
            ]);
            $table->addColumn('name', 'string', [
                'notnull' => true,
                'length' => 200
            ]);
            $table->addColumn('material', 'string', [
                'notnull' => true,
                'length' => 200,
            ]);
            $table->addColumn('quantity', 'integer', [
                'notnull' => true,
                'default' => '1'
            ]);
            $table->addColumn('date', 'datetime', [
                'notnull' => true,
                'default' => '1800-01-01'
            ]);

            $table->setPrimaryKey(['id']);
        }

        if (!$schema->hasTable('material')) {
            $table = $schema->createTable('material');
            $table->addColumn('id', 'integer', [
                'autoincrement' => true,
                'notnull' => true,
            ]);
            $table->addColumn('name', 'string', [
                'notnull' => true,
                'length' => 200
            ]);
            $table->addColumn('quantity', 'integer', [
                'notnull' => true,
                'default' => '1'
            ]);

            $table->setPrimaryKey(['id']);
        }
        return $schema;
    }
}