<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 21.05.2020
 * Time: 21:44
 */
?>
<script>
    Ext.onReady(function(){
        Ext.define('TechZoo.BaseTab', {
            extend  : 'Ext.panel.Panel',
            alias   : 'widget.base_tab',
            closable: true,
            border  : false,
            initComponent  : function() {
                this.addListener({
                    beforeclose :{
                        fn    : this.onClose,
                        scope : this
                    }
                });
                this.callParent(arguments);
            },

            onClose: function(me) {
                var bar       = me.up('tabpanel').getTabBar(),
                    tabsCount   = bar.items.length;

                if(tabsCount > 1) {
                    Ext.Msg.show({
                        title   : 'Подтверждение',
                        msg     : 'Вы действительно хотите закрыть вкладку \'' + me.title + '\' ?',
                        width   : 400,
                        icon    : Ext.MessageBox.INFO,
                        buttons : Ext.MessageBox.OKCANCEL,
                        fn      : function(btn){
                            switch(btn){
                                case 'ok':
                                    this.ownerCt.remove(me);
                                    break;
                                case 'cancel':
                                    break;
                            }
                        },
                        scope: this
                    });
                }
                else {
                    Ext.Msg.show({
                        title   : 'Error !',
                        msg     : 'You can\'t close \'' + me.title +'\' panel.<br/>'+
                        '<br/>Application requires atleast one panel to be rendered.',
                        width   : 400,
                        icon    : Ext.MessageBox.ERROR,
                        buttons : Ext.Msg.OK
                    });
                }
                return false;
            }
        });

        Ext.define('TechZoo.Tab1', {
            extend  : 'TechZoo.BaseTab',
            alias   : 'widget.cTab'
        });

        var myData = [
            ['Виктор', 'Чепель', 'chepelvn@yandex.ru', '+79883141493',  'PR'],
        ];

        var store = Ext.create('Ext.data.ArrayStore', {
            fields: ['company','price','change','pctChange','lastChange'],
            data: myData
        });

        var Table = Ext.create('Ext.grid.Panel', {
            store: store,
            title: 'Таблица',
            columns: [
                {
                    text     : 'Имя',
                    dataIndex: 'company'
                },
                {
                    text     : 'Фамилия',
                    dataIndex: 'price'
                },
                {
                    text     : 'Email',
                    dataIndex: 'change'
                },
                {
                    text     : 'Телефон',
                    dataIndex: 'pctChange'
                },
                {
                    text     : 'Организация',
                    dataIndex: 'lastChange'
                }
            ],
            listeners : {
                itemdblclick: function(dv, record, item, index, e) {
                    var Form = Ext.create('Ext.form.Panel', {
                        title: 'Редактировать объект',
                        bodyPadding: 5,
                        width: 450,
                        url: 'TableItemsEditor',
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'textfield',
                        items: [{
                            fieldLabel: 'Имя',
                            name: 'first_name',
                            allowBlank: false,
                            emptyText: 'Введите имя'
                        },{
                            fieldLabel: 'Фамилия',
                            name: 'last_name',
                            allowBlank: false,
                            emptyText: 'Введите фамилию'
                        },{
                            fieldLabel: 'Email',
                            name: 'email',
                            emptyText: 'login@domain.ru'
                        },{
                            fieldLabel: 'Телефон',
                            name: 'phone'
                        },{
                            fieldLabel: 'Возраст',
                            name: 'years'
                        },{
                            fieldLabel: 'Организация',
                            name: 'company'
                        },{
                            xtype     : 'textareafield',
                            fieldLabel: 'Адрес',
                            name: 'address'
                        },{
                            xtype     : 'textareafield',
                            fieldLabel: 'Дополнительное описание',
                            name: 'desc',
                            emptyText: 'Произвольное описание, примечания'
                        }],
                        buttons: [{
                            text: 'Reset',
                            handler: function() {
                                this.up('form').getForm().reset();
                            }
                        }, {
                            text: 'Submit',
                            formBind: true, //only enabled once the form is valid
                            disabled: true,
                            handler: function() {
                                var form = this.up('form').getForm();
                                if (form.isValid()) {
                                    form.submit({
                                        success: function(form, action) {
                                            Ext.Msg.alert('Success', action.result.msg);
                                        },
                                        failure: function(form, action) {
                                            Ext.Msg.alert('Failed', action.result.msg);
                                        }
                                    });
                                }
                            }
                        }]
                    });
                    Tabs.add(Form).show();
                }
            }
        });

        var Tabs = Ext.create('Ext.tab.Panel', {
            fullscreen: true,
            allowDomMove: true,
            title: 'Главная страница',
            items:[Table],
            renderTo: 'panel'
        });
    });

</script>
<div id="grid1"></div>
<div id="panel"></div>
