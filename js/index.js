$(function() {
    var $wrap = $('.wrap'),
        $popup = $('#detailPop'),
        $search = $('.card-search');

    var api = location.origin + '/api';

    //分页
    $('#listPagination').jqPaginator({
        totalPages: 1,
        pageSize: 10,
        visiblePages: 4,
        currentPage: 1,
        totalLine: 0,
        onPageChange: function (pageNum, type) {
            if (type != 'init') {
                getList(pageNum);
            }
        }
    });

    // 获取列表
    var getList = function(pageNum) {
        var name = $.trim($search.find('[name=name]').val());
        var email = $.trim($search.find('[name=email]').val());

        var data  = {
            pageNum: pageNum || 1,
            pageSize: 10
        };

        if (name) {
            data.name = name;
        }

        if (email) {
            data.email = email;
        }

        $.ajax({
            url: api + '/test/getlist',
            type: 'GET',
            dataType: 'json',
            data: data,
            success: function(response) {
                // 渲染列表
                var listHtml = doT.template($("#listTmpl").html());
                $('#lists').html(listHtml(response.data.dataList));

                // 渲染分页
                if (response.data.totalPage > 1) {
                    $('#listPagination').jqPaginator('option', {
                        totalPages: response.data.totalPage,
                        pageSize: data.pageSize,
                        currentPage: data.pageNum,
                        totalLine: response.data.totalLine
                    });
                } else {
                    $('#listPagination').html('').addClass('hide');
                }
            }
        });
    };

    getList();

    // 搜索
    $search.on('click', '.btn-search', function() {
        getList();
    });

    // 重置搜索
    $search.on('click', '.btn-reset', function() {
        $search.find('[name=name]').val('');
        $search.find('[name=email]').val('');
        getList();
    });

    // 渲染详情
    var renderDetail = function(data) {
        var detailHtml = doT.template($("#detailTmpl").html());
        $popup.html(detailHtml(data)).removeClass('hide');
    };

    // 新增
    $wrap.on('click', '.btn-add', function() {
        var data = {
            id: '',
            name: '',
            title: '',
            email: '',
            type: 'add'
        };

        renderDetail(data);
    });

    // 修改
    $wrap.on('click', '.btn-edit', function() {
        var id = $(this).data('id');

        if (!id) {
            return;
        }

        $.ajax({
            url: api + '/test/detail',
            type: 'GET',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(response) {
                response.data.type = '修改';
                renderDetail(response.data);
            }
        });
    });

    // 弹窗input校验
    $popup.on('click', '[name=name],[name=title]', function() {
        $(this).closest('.form-group').removeClass('error');
    });
    $popup.on('blur', '[name=name],[name=title]', function() {
        var $this = $(this),
            $group = $this.closest('.form-group'),
            val = $.trim($this.val());

        if (!val) {
            return $group.addClass('error');
        } else {
            $group.removeClass('error');
        }
    });

    // 弹窗 保存
    $popup.on('click', '.btn-confirm', function() {
        var type = $(this).data('type'),
            id = $popup.find('[name=id]').val(),
            url;

        $popup.find('[name=name],[name=title]').trigger('blur');

        if ($popup.find('.error').length) {
            return;
        }

        if (type == 'add') {
            url = '/test/add';
        } else {
            url = '/test/update';
        }

        var data = {
            name: $.trim($popup.find('[name=name]').val()),
            title: $.trim($popup.find('[name=title]').val()),
            email: $.trim($popup.find('[name=email]').val())
        };

        if (id) {
            data.id = id;
        }

        $.ajax({
            url: api + url,
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                $popup.addClass('hide');
                getList();
            }
        })
    });

    // 弹窗关闭
    $popup.on('click', '.btn-cancel,.alert-close', function() {
        $popup.addClass('hide');
    });

    // 删除
    $wrap.on('click', '.btn-del', function() {
        var id = $(this).data('id');

        if (!id) {
            return;
        }

        if (confirm('确认要删除该条数据？')) {
            $.ajax({
                url: api + '/test/delete',
                type: 'GET',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(response) {
                    getList();
                }
            });
        }
    });

    // 验证
    $wrap.on('click', '.btn-check', function() {
        var name = $(this).data('name');

        if (!name) {
            return;
        }

        $.ajax({
            url: api + '/test/check',
            type: 'GET',
            dataType: 'json',
            data: {
                name: name
            },
            success: function(response) {
                alert(response.retMsg);
            }
        });
    });
});
