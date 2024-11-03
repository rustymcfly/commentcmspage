const params = new URLSearchParams(window.location.search)
if (params.has('commentId')) {
    const el = document.querySelector(`[data-comment-id="${params.get('commentId')}"]`)
    el.classList.add('blink')
    el.scrollIntoView({behavior: 'smooth'})
}
