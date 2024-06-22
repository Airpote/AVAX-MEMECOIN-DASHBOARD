<div id="price-{{ $tokenName }}"></div>

<script>
window.onload = async function() {
  const tokenName = "{{ $tokenName }}"; // Extract token name from Blade parameter

  // Logic to map token names to API URLs (replace with your actual implementation)
  const tokenMap = {
    'AMI': 'https://api.dexscreener.com/latest/dex/pairs/avalanche/0xf5b1eb43e0c3583e2969050a79fd86b1891db826',
    'COQ': 'https://api.dexscreener.com/latest/dex/pairs/avalanche/0x41ab86eecbd110a82ca602d032a461f453066f1e',
    'HEFE': 'https://api.dexscreener.com/latest/dex/pairs/avalanche/0x41ab86eecbd110a82ca602d032a461f453066f1e',
    'TECH': 'https://api.dexscreener.com/latest/dex/pairs/avalanche/0xe1d895ff6721a77c16f4c53eeb43869da2dab02f',
    'KIMBO': 'https://api.dexscreener.com/latest/dex/pairs/avalanche/0x03a5888726667fff1e753fc06b51dd1245e7371a',
    'JOE': 'https://api.dexscreener.com/latest/dex/pairs/avalanche/0x454e67025631c065d3cfad6d71e6892f74487a15',
  };

  const apiUrl = tokenMap[tokenName]; // Retrieve URL based on token name

  if (apiUrl) { // Check if token exists in map
    try {
      const response = await fetch(apiUrl);
      const data = await response.json();
      const priceUsd = parseFloat(data.pair?.priceUsd); // Use optional chaining

      if (priceUsd) {
        const formattedPrice = priceUsd.toLocaleString('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 8 }); // Format with 1-8 decimals

        document.getElementById(`price-${tokenName}`).textContent = `$${formattedPrice}`; // Update price element
      } else {
        console.warn(`Price data not found for token: ${tokenName}`);
      }
    } catch (error) {
      console.error('Error fetching data for token:', tokenName, error);
    }
  } else {
    console.warn(`No API URL found for token: ${tokenName}`);
  }
};
</script>     