const {
  HOSTNAME
} = process.env;

const editPage = (model,data) => {
  const firstPage = data.data.first_page_url.split('?').pop();
  const lastPage = data.data.last_page_url.split('?').pop();
  const nextPage = data.data?.next_page_url?.split('?').pop() ?? '';
  const prevPage = data.data?.prev_page_url?.split('?').pop() ?? '';
  data.data.first_page_url = `${HOSTNAME}/${model}?${firstPage}`;
  data.data.last_page_url = `${HOSTNAME}/${model}?${lastPage}`;
  data.data.path = `${HOSTNAME}/${model}`;
  data.data.next_page_url = nextPage ? `${HOSTNAME}/${model}?${nextPage}` : null;
  data.data.prev_page_url = prevPage ? `${HOSTNAME}/${model}?${prevPage}` : null;
  return data
}

module.exports = editPage;