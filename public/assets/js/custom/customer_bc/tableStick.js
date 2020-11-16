/*var $table = $('#cball_table')

  function buildTable($el, cells, rows) {
    var i
    var j
    var row
    var columns = []
    var data = []

    for (i = 0; i < cells; i++) {
      columns.push({
        field: 'field' + i,
        title: 'Cell' + i,
        sortable: true
      })
    }
    for (i = 0; i < rows; i++) {
      row = {}
      for (j = 0; j < cells; j++) {
        row['field' + j] = 'Row-' + i + '-' + j
      }
      data.push(row)
    }


    $el.bootstrapTable('destroy').bootstrapTable({
      columns: columns,
      data: data,
      showFullscreen: true,
      search: true,
      stickyHeader: true,
      stickyHeaderOffsetLeft: '3em',
      stickyHeaderOffsetRight: '3em'
    })
  }

  $(function() {
    buildTable($table, 56, 14)
  })*/