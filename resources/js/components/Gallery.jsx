
import React, { useEffect, useState } from 'react';
import axios from 'axios';

// Use Vite env vars
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;

export default function Gallery() {
    const [images, setImages] = useState([]);
    const [image, setImage] = useState(null);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        fetchImages();

        if (window.Echo) {
            window.Echo.channel('gallery-channel')
                .listen('ImageUpdated', () => {
                    fetchImages();
                });
        }
    }, []);

    const fetchImages = async () => {
        try {
            const res = await axios.get('/api/gallery');
            setImages(res.data);
        } catch (err) {
            console.error('Fetch failed:', err);
        }
    };

    const upload = async () => {
        if (!image) return;

        setLoading(true);
        const form = new FormData();
        form.append('image', image);

        try {
            await axios.post('/api/gallery', form);
            setImage(null);
            fetchImages();
        } catch (err) {
            console.error('Upload failed:', err);
        } finally {
            setLoading(false);
        }
    };

    const remove = async (id) => {
        try {
            await axios.delete(`/api/gallery/${id}`);
            // fetchImages();
             setImages(images.filter(img => img.id !== id));
        } catch (err) {
            console.error('Delete failed:', err);
        }
    };

    return (
        <div style={{ padding: '2rem' }}>
            <h2>Image Gallery</h2>
            <input type="file" onChange={(e) => setImage(e.target.files[0])} />
            <button onClick={upload} disabled={loading}>
                {loading ? 'Uploading...' : 'Upload'}
            </button>

            <div style={{ marginTop: '2rem' }}>
                {images.map(img => (
                    <div key={img.id} style={{ marginBottom: '1rem' }}>
                        <img
                            src={`${import.meta.env.VITE_STORAGE_URL}/${img.image_path}`}
                            alt="gallery"
                            style={{ width: '150px', border: '1px solid #ccc' }}
                        />
                        <br />
                        <button onClick={() => remove(img.id)}>Delete</button>
                    </div>
                ))}
            </div>
        </div>
    );
}
