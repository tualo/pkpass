DELIMITER;

INSERT INTO
    `ds` (
        `table_name`,
        `title`,
        `reorderfield`,
        `use_history`,
        `searchfield`,
        `displayfield`,
        `sortfield`,
        `searchany`,
        `hint`,
        `overview_tpl`,
        `sync_table`,
        `writetable`,
        `globalsearch`,
        `listselectionmodel`,
        `sync_view`,
        `syncable`,
        `cssstyle`,
        `alternativeformxtype`,
        `read_table`,
        `class_name`,
        `special_add_panel`,
        `existsreal`,
        `character_set_name`,
        `read_filter`,
        `listxtypeprefix`,
        `phpexporter`,
        `phpexporterfilename`,
        `combined`,
        `default_pagesize`,
        `allowForm`,
        `listviewbaseclass`,
        `showactionbtn`,
        `modelbaseclass`
    )
VALUES
    (
        'pkpass_environment',
        'pkpass: Webhook-Umgebung',
        NULL,
        NULL,
        'id',
        'id',
        'id',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        'rowmodel',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        'Unklassifiziert',
        NULL,
        1,
        NULL,
        NULL,
        NULL,
        'XlsxWriter',
        'pkpass_environment {DATE} {TIME}',
        0,
        1000,
        1,
        'Tualo.DataSets.ListView',
        1,
        'Tualo.DataSets.model.Basic'
    ) ON DUPLICATE KEY
UPDATE
    title =
VALUES
(title),
    reorderfield =
VALUES
(reorderfield),
    use_history =
VALUES
(use_history),
    searchfield =
VALUES
(searchfield),
    displayfield =
VALUES
(displayfield),
    sortfield =
VALUES
(sortfield),
    searchany =
VALUES
(searchany),
    hint =
VALUES
(hint),
    overview_tpl =
VALUES
(overview_tpl),
    sync_table =
VALUES
(sync_table),
    writetable =
VALUES
(writetable),
    globalsearch =
VALUES
(globalsearch),
    listselectionmodel =
VALUES
(listselectionmodel),
    sync_view =
VALUES
(sync_view),
    syncable =
VALUES
(syncable),
    cssstyle =
VALUES
(cssstyle),
    alternativeformxtype =
VALUES
(alternativeformxtype),
    read_table =
VALUES
(read_table),
    class_name =
VALUES
(class_name),
    special_add_panel =
VALUES
(special_add_panel),
    existsreal =
VALUES
(existsreal),
    character_set_name =
VALUES
(character_set_name),
    read_filter =
VALUES
(read_filter),
    listxtypeprefix =
VALUES
(listxtypeprefix),
    phpexporter =
VALUES
(phpexporter),
    phpexporterfilename =
VALUES
(phpexporterfilename),
    combined =
VALUES
(combined),
    default_pagesize =
VALUES
(default_pagesize),
    allowForm =
VALUES
(allowForm),
    listviewbaseclass =
VALUES
(listviewbaseclass),
    showactionbtn =
VALUES
(showactionbtn),
    modelbaseclass =
VALUES
(modelbaseclass);

INSERT
    IGNORE INTO `ds_column` (
        `table_name`,
        `column_name`,
        `default_value`,
        `default_max_value`,
        `default_min_value`,
        `update_value`,
        `is_primary`,
        `syncable`,
        `referenced_table`,
        `referenced_column_name`,
        `is_nullable`,
        `is_referenced`,
        `writeable`,
        `note`,
        `data_type`,
        `column_key`,
        `column_type`,
        `character_maximum_length`,
        `numeric_precision`,
        `numeric_scale`,
        `character_set_name`,
        `privileges`,
        `existsreal`,
        `deferedload`,
        `hint`,
        `fieldtype`
    )
VALUES
    (
        'pkpass_environment',
        'id',
        NULL,
        NULL,
        NULL,
        NULL,
        1,
        NULL,
        NULL,
        NULL,
        'NO',
        NULL,
        1,
        NULL,
        'varchar',
        'PRI',
        'varchar(255)',
        255,
        NULL,
        NULL,
        'utf8mb4',
        'select,insert,update,references',
        1,
        NULL,
        NULL,
        ''
    ),
    (
        'pkpass_environment',
        'val',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        'NO',
        NULL,
        1,
        NULL,
        'longtext',
        '',
        'longtext',
        4294967295,
        NULL,
        NULL,
        'utf8mb4',
        'select,insert,update,references',
        1,
        NULL,
        NULL,
        ''
    );

INSERT
    IGNORE INTO `ds_column_list_label` (
        `table_name`,
        `column_name`,
        `language`,
        `label`,
        `xtype`,
        `editor`,
        `position`,
        `summaryrenderer`,
        `renderer`,
        `summarytype`,
        `hidden`,
        `active`,
        `filterstore`,
        `grouped`,
        `flex`,
        `direction`,
        `align`,
        `listfiltertype`,
        `hint`
    )
VALUES
    (
        'pkpass_environment',
        'id',
        'DE',
        'ID',
        'gridcolumn',
        NULL,
        0,
        '',
        '',
        '',
        0,
        1,
        '',
        0,
        1.00,
        'ASC',
        'left',
        '',
        NULL
    ),
    (
        'pkpass_environment',
        'val',
        'DE',
        'Wert',
        'gridcolumn',
        NULL,
        1,
        '',
        '',
        '',
        0,
        1,
        '',
        0,
        1.00,
        'ASC',
        'left',
        '',
        NULL
    );

INSERT
    IGNORE INTO `ds_column_form_label` (
        `table_name`,
        `column_name`,
        `language`,
        `label`,
        `xtype`,
        `field_path`,
        `position`,
        `hidden`,
        `active`,
        `allowempty`,
        `fieldgroup`,
        `flex`,
        `hint`
    )
VALUES
    (
        'pkpass_environment',
        'id',
        'DE',
        'ID',
        'displayfield',
        'Allgemein/Angaben',
        0,
        0,
        1,
        NULL,
        NULL,
        NULL,
        '\'\''
    ),
    (
        'pkpass_environment',
        'val',
        'DE',
        'Wert',
        'textfield',
        'Allgemein/Angaben',
        1,
        0,
        1,
        NULL,
        NULL,
        NULL,
        '\'\''
    );

INSERT
    IGNORE INTO `ds_access` (
        `role`,
        `table_name`,
        `read`,
        `write`,
        `delete`,
        `append`,
        `existsreal`
    )
VALUES
    (
        'administration',
        'pkpass_environment',
        1,
        1,
        NULL,
        NULL,
        NULL
    );