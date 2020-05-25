
Ext.onReady(function(){
    var wrapPanel = document.createElement('div');
    wrapPanel.id = 'panel';
    document.body.append(wrapPanel);

    Ext.define('myModel', {
        extend: 'Ext.data.Model',
        fields: ['first_name','last_name','email','phone','company', 'id', 'age', 'desc', 'address']
    });

    var store = Ext.create('Ext.data.Store', {
        model: 'myModel',
        proxy: {
            type: 'ajax',
            url: '/Users/getItems',
            reader: {
                type: 'json',
                root: 'data'
            }
        },
        autoLoad: true
    });

    var FormsCollection = {};

    var Table = Ext.create('Ext.grid.Panel', {
        closable : true,
        store: store,
        title: 'Список',
        columns: [
            {
                text     : 'Имя',
                dataIndex: 'first_name'
            },
            {
                text     : 'Фамилия',
                dataIndex: 'last_name'
            },
            {
                text     : 'Email',
                dataIndex: 'email'
            },
            {
                text     : 'Телефон',
                dataIndex: 'phone'
            },
            {
                text     : 'Организация',
                dataIndex: 'company'
            }
        ],
        listeners : {
            itemdblclick: function(dv, record, item, index, e) {
                var dataUser = this.store.data.items[index].data;
                var userId = dataUser['id'];
                if(FormsCollection[index]){
                    FormsCollection[index].show();
                } else {
                    var Form = Ext.create('Ext.form.Panel', {
                        title: dataUser['last_name'] + ' ' + dataUser['first_name'],
                        bodyPadding: 5,
                        width: 450,
                        url: '/UsersEditor/edit/' + userId,
                        layout: 'anchor',
                        defaults: {
                            anchor: '100%'
                        },
                        defaultType: 'textfield',
                        items: [{
                            fieldLabel: 'Имя',
                            name: 'first_name',
                            allowBlank: false,
                            emptyText: 'Введите имя',
                            value: dataUser['first_name']
                        }, {
                            fieldLabel: 'Фамилия',
                            name: 'last_name',
                            allowBlank: false,
                            emptyText: 'Введите фамилию',
                            value: dataUser['last_name']
                        }, {
                            fieldLabel: 'Email',
                            name: 'email',
                            emptyText: 'login@domain.ru',
                            value: dataUser['email']
                        }, {
                            fieldLabel: 'Телефон',
                            name: 'phone',
                            value: dataUser['phone']
                        }, {
                            xtype: 'numberfield',
                            fieldLabel: 'Возраст',
                            name: 'age',
                            value: dataUser['age']
                        }, {
                            fieldLabel: 'Организация',
                            name: 'company',
                            value: dataUser['company']
                        }, {
                            xtype: 'textareafield',
                            fieldLabel: 'Адрес',
                            name: 'address',
                            value: dataUser['address']
                        }, {
                            xtype: 'textareafield',
                            fieldLabel: 'Дополнительное описание',
                            name: 'desc',
                            emptyText: 'Произвольное описание, примечания',
                            value: dataUser['desc']
                        }],
                        buttons: [{
                            text: 'Отмена',
                            handler: function () {
                                var bar = this.up('tabpanel');
                                var tabActive = bar.getActiveTab();
                                Ext.Msg.show({
                                    title: 'Подтверждение',
                                    msg: 'Вы действительно хотите закрыть \'' + tabActive.title + '\'?',
                                    width: 400,
                                    icon: Ext.MessageBox.INFO,
                                    buttons: Ext.MessageBox.OKCANCEL,
                                    buttonText: {
                                        ok: 'Закрыть',
                                        cancel: 'Отмена'
                                    },
                                    fn: function (btn) {
                                        switch (btn) {
                                            case 'ok':
                                                delete FormsCollection[index];
                                                bar.remove(tabActive);
                                                break;
                                            case 'cancel':
                                                break;
                                        }
                                    },
                                    scope: this
                                });
                            }
                        }, {
                            text: 'Сохранить',
                            formBind: true,
                            disabled: true,
                            handler: function () {
                                var form = this.up('form').getForm();
                                if (form.isValid()) {
                                    form.submit({
                                        success: function (form, action) {
                                            Ext.Msg.alert('Success', action.result.msg);
                                        },
                                        failure: function (form, action) {
                                            Ext.Msg.alert('Failed', action.result.msg);
                                        }
                                    });
                                }
                            }
                        }]
                    });
                    FormsCollection[index] = Form;
                    Tabs.add(Form).show();
                }
            }
        }
    });

    var Tabs = Ext.create('Ext.tab.Panel', {
        fullscreen: true,
        allowDomMove: true,
        title: 'Пользователи',
        items:[Table],
        renderTo: wrapPanel.id
    });
});