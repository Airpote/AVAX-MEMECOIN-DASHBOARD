<div id="price-{{ $suffix }}"></div>
<div id="address-{{ $suffix }}"></div>
<div id="price-native-{{ $suffix }}"></div>
<div id="socials-{{ $suffix }}"></div>

<script>
async function fetchTokenData(suffix, tokenName, apiUrl, displayMap) {
  try {
    const response = await fetch(apiUrl);
    const data = await response.json();
    const pair = data.pair;

    // Display based on the display map
    if (displayMap['Price']) {
      const priceUsd = parseFloat(pair?.priceUsd); // Fetch priceUsd
      // Display price in USD
      if (priceUsd) {
        const formattedPriceUsd = `$${priceUsd.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 8 })}`;
        document.getElementById(`price-${suffix}`).textContent = formattedPriceUsd;
      } else {
        console.warn(`Price data not found for token: ${tokenName}`);
      }
    }

    if (displayMap['PriceNative']) {
      const priceNative = parseFloat(pair?.priceNative); // Fetch priceNative
      // Display price in native currency
      if (priceNative) {
        const formattedPriceNative = `${priceNative.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 8 })} avax`;
        document.getElementById(`price-native-${suffix}`).textContent = formattedPriceNative;
      }
    }

    if (displayMap['Address']) {
      const baseTokenAddress = pair?.baseToken?.address; // Fetch baseToken address
      // Display base token address
      if (baseTokenAddress) {
        document.getElementById(`address-${suffix}`).textContent = `Base Token Address: ${baseTokenAddress}`;
      }
    }

    if (displayMap['Socials']) {
      const socials = pair?.info?.socials; // Fetch social links
      // Display social links in uppercase with "of [token name]"
      if (socials && Array.isArray(socials)) {
        const socialsList = socials.map(social => `<li><a href="${social.url}" target="_blank">${social.type.toUpperCase()} of ${tokenName}</a></li>`).join('');
        document.getElementById(`socials-${suffix}`).innerHTML = `<ul>${socialsList}</ul>`;
      }
    }

  } catch (error) {
    console.error('Error fetching data for token:', tokenName, error);
  }
}

document.addEventListener('DOMContentLoaded', async function() {
  const suffix = "{{ $suffix }}"; // Extract suffix from Blade parameter
  const tokenName = "{{ $tokenName }}"; // Extract token name from Blade parameter
  const displayMap = @json($displayMap); // Extract display map from Blade parameter
  const apiUrl = @json($apiUrl); // Extract API URL from Blade parameter

  fetchTokenData(suffix, tokenName, apiUrl, displayMap);
});
</script>