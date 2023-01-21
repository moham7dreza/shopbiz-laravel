function commentable(id, name) {
var element = $("#" + id + '-commentable')
var url = element.attr('data-url')
var elementValue = !element.prop('checked');

$.ajax({
url: url,
type: "GET",
success: function (response) {
if (response.commentable) {
if (response.checked) {
element.prop('checked', true);
successToast('امکان افزودن نظر برای ' + name + ' با موفقیت فعال شد ')
} else {
element.prop('checked', false);
warningToast('امکان افزودن نظر برای ' + name + ' با موفقیت غیر فعال شد ')
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
