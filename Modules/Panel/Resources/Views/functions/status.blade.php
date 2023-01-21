function changeStatus(id, name) {
var element = $("#" + id)
var url = element.attr('data-url')
var elementValue = !element.prop('checked');

$.ajax({
url: url,
type: "GET",
success: function (response) {
if (response.status) {
if (response.checked) {
element.prop('checked', true);
successToast('وضعیت ' + name + ' با موفقیت فعال شد ')
} else {
element.prop('checked', false);
warningToast('وضعیت ' + name + ' با موفقیت غیر فعال شد ')
}
} else {
element.prop('checked', elementValue);
errorToast('هنگام ویرایش مشکلی بوجود امده است')
}
},
error: function () {
element.prop('checked', elementValue);
errorToast('ارتباط برقرار نشد')
}
});
}
