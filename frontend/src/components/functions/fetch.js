export const FetchProduct = async (url, productId) => {
  return fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      query: `
      query ($id: String!) {
        products(id: $id) {
          id
          name
          description
          price {
            amount
            currencyLabel
            currencySymbol
          }
          gallery
          category
          brand
          inStock
          attributes {
            id
            items {
              displayValue
              value
            }
          }
        }
      }`,
      variables: {
        id: productId,
      },
    }),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => data)
    .catch((error) => {
      console.error(error);
      throw error;
    });
};



export const FetchData = async (url) => {
  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        query: `
          query {
            products {
              id
          name
          description
          price {
            amount
            currencyLabel
            currencySymbol
          }
          gallery
          category
          brand
          inStock
          attributes {
            id
            items {
              displayValue
              value
                }
              }
            }
          }
        `,
      }),
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    return data;
  } catch (error) {
    console.log(json_encode(error)); 
    throw error;
  }
};




