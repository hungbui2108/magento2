<?php
/**
 * User: smart
 * Date: 21-12-2017
 * Time: 9:39 SA
 */

namespace Hungbd\Slider\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements  InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('hungbd_slider')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('hungbd_slider')
            )->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'Slider ID'
            )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false,],
                    'Slider Name'
                )
                ->setComment('Slider Table');

            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists('hungbd_image')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('hungbd_image')
            )->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'Slider ID'
            )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false,],
                    'Image Name'
                )
                ->addColumn(
                    'link',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false,],
                    'Image Link'
                )
                ->setComment('Image Table');

            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists('hungbd_list')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('hungbd_list')
            )->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'ID'
            )->addColumn(
                'slider_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'unsigned' => true,
                ],
                'Slider ID'
            )
                ->addColumn(
                    'image_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'image ID'
                )
                ->setComment('List Slider Image Table');

            $installer->getConnection()->createTable($table);

            $setup->getConnection()->addForeignKey(
                $setup->getFkName(
                    'hungbd_list', 'slider_id', 'hungbd_slider', 'id'
                ),
                $setup->getTable('hungbd_list'),
                'slider_id',
                $setup->getTable('hungbd_slider'),
                'id',
                Table::ACTION_CASCADE
            );
            $setup->getConnection()->addForeignKey(
                $setup->getFkName(
                    'hungbd_list', 'image_id', 'hungbd_image', 'id'
                ),
                $setup->getTable('hungbd_list'),
                'image_id',
                $setup->getTable('hungbd_image'),
                'id',
                Table::ACTION_CASCADE
            );
        }
        $installer->endSetup();
    }
}